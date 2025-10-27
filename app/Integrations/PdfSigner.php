<?php

namespace App\Integrations;

use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Tcpdf\Fpdi as TcpdfFpdi;
use Smalot\PdfParser\Parser as PdfParser;

class PdfSigner
{
    protected string $certFile;
    protected string $privateKey;
    protected string $password;

    public function __construct()
    {
        $this->certFile = storage_path('app/certs' . settings('document_signer_certificate_path'));
        $this->privateKey = storage_path('app/certs' . settings('document_signer_private_key_path'));
        $this->password = settings('document_signer_private_key_password');
    }

    public function signPdfInvisible(string $inputPath, string $outputPath, array $meta = [], $signatureId = null): string
    {
        $pdf = new TcpdfFpdi();

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Import existing PDF
        $pageCount = $pdf->setSourceFile($inputPath);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $tplIdx = $pdf->importPage($pageNo);
            $pdf->AddPage();
            $pdf->useTemplate($tplIdx, 0, 0, null, null, true);
        }
        // Set metadata for signature
        $info = [
            'Name' => $meta['name'] ?? 'Signer',
            'ContactInfo' => $meta['email'] ?? '',
            'Location' => $meta['location'] ?? null,
            'Reason' => $meta['reason'] ?? 'Document Signature',
            'Date' => date('YmdHisO'),
        ];

        // Setup digital signature
        $pdf->setSignature('file://' . $this->certFile, 'file://' . $this->privateKey, $this->password, '', 2, $info);
        // Output signed PDF
        $pdf->Output($outputPath, 'F');

        return $outputPath;
    }

    public function signPdfVisibleSignature(
        string $inputPath,
        string $outputPath,
        array $meta = [],
        $signatureId = null,
        $isFirstSignature = false,
    ): string {
        $pdf = new TcpdfFpdi();

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $signatureCord = $this->calculateSignaturePosition($inputPath, $signatureId);

        // Import existing PDF
        $pageCount = $pdf->setSourceFile($inputPath);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $tplIdx = $pdf->importPage($pageNo);
            $pdf->AddPage();
            $pdf->useTemplate($tplIdx, 0, 0, null, null, true);

            if ($pageNo == $signatureCord['page']) {
                if (!empty($meta['signature_image'])) {
                    // Set metadata for signature
                    $info = [
                        'Name' => $meta['name'] ?? 'Signer',
                        'ContactInfo' => $meta['email'] ?? '',
                        'Location' => $meta['location'] ?? null,
                        'Reason' => $meta['reason'] ?? 'Document Signature',
                        'Date' => date('YmdHisO'),
                    ];

                    // Setup digital signature
                    $pdf->setSignature(
                        'file://' . $this->certFile,
                        'file://' . $this->privateKey,
                        $this->password,
                        '',
                        2,
                        $info,
                        $isFirstSignature,
                    );

                    $coord = $signatureCord;

                    // Visual signature is in base64 image -> need convert to png
                    $img = base64_decode(preg_replace('#^data:image/[^;]+;base64,#', '', $meta['signature_image']));
                    $pdf->Text($coord['x'], $coord['y'], __('pdf.signer'));
                    $pdf->Text(
                        $coord['x'],
                        $coord['y'] + 5,
                        '(' .
                            __('pdf.signed_by') .
                            ' ' .
                            ($meta['name'] ?? 'Signer') .
                            ' ' .
                            __('pdf.on') .
                            ' ' .
                            date('Y-m-d H:i:s') .
                            ')',
                    );
                    $pdf->Image('@' . $img, $coord['x'], $coord['y'] + 10, 50, 25, 'PNG');
                    $pdf->setSignatureAppearance(
                        $coord['x'],
                        $coord['y'],
                        120,
                        40,
                        $coord['page'],
                        'Signature_' . ($signatureId ?? uniqid()),
                    );
                }
            }
        }

        // Output signed PDF
        $pdf->Output($outputPath, 'F');

        return $outputPath;
    }

    protected function calculateSignaturePosition($inputPath, $signatureId)
    {
        $parser = new PdfParser();
        $pdf = $parser->parseFile($inputPath);
        $pages = $pdf->getPages();

        foreach ($pages as $index => $page) {
            $position = $this->findSignaturePositionInPage($page, $index, $signatureId);
            if ($position['x'] > 0 && $position['y'] > 0) {
                return $position;
            }
        }
    }

    protected function findSignaturePositionInPage($page, $pageIndex, $signatureId)
    {
        $dataTm = $page->getDataTm();

        $details = $page->getDetails();
        $page_height = $details['MediaBox'][3];

        $x = 0;
        $y = 0;

        $keyword = '[[SIGNATURE_' . $signatureId . ']]';

        foreach ($dataTm as $element) {
            $pos = strpos($element[1], $keyword);
            if ($pos !== false) {
                $x = $element[0][4] * 0.352777778;
                $y = ($page_height - $element[0][5]) * 0.352777778;
            }
        }

        Log::info('Calculated signature position for signature ID ' . $signatureId . ': x=' . $x . ', y=' . $y . ' on page ' . $pageIndex);
        return ['x' => $x, 'y' => $y, 'page' => $pageIndex];
    }
}
