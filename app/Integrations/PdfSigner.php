<?php

namespace App\Integrations;

use ddn\sapp\PDFDoc;

class PdfSigner
{
    protected string $certFile;
    protected string $privateKey;
    protected string $p12File;
    protected string $password;

    public function __construct()
    {
        $this->certFile = storage_path('app/certs' . settings('document_signer_certificate_path'));
        $this->privateKey = storage_path('app/certs' . settings('document_signer_private_key_path'));
        $this->p12File = storage_path('app/certs' . settings('document_signer_p12_path'));
        $this->password = settings('document_signer_private_key_password');
    }

    public function signPdfInvisible(string $inputPath, string $outputPath, array $meta = [], $signatureId = null): string
    {
        $pdf = PDFDoc::from_string(file_get_contents($inputPath));

        // Set metadata for signature
        $pdf->set_metadata_props(
            $meta['name'] ?? 'Signer',
            $meta['reason'] ?? 'Document Signature',
            $meta['location'] ?? null,
            $meta['email'] ?? null,
        );

        // Sign the PDF
        $pdfContent = $pdf->sign_document($this->p12File, $this->password);

        $pdfFile = $pdf->to_pdf_file($outputPath);

        return $outputPath;
    }
}
