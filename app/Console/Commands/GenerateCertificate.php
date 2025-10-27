<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;

class GenerateCertificate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biznisbox:generate-certificate
                            {--password= : Password for the private key}
                            {--days=365 : Validity of the certificate in days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a self-signed certificate for PDF signing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $certDir = storage_path('app/certs');
        if (!is_dir($certDir)) {
            mkdir($certDir, 0700, true);
        }

        $password = $this->option('password') ?? bin2hex(random_bytes(8));
        $days = $this->option('days');

        $privateKey = $certDir . '/private_key.pem';
        $certificate = $certDir . '/certificate.pem';
        $pfx = $certDir . '/server-cert.p12';

        $this->info('🛠️  Generating certificate in: ' . $certDir);

        // Create private key and self-signed certificate
        $this->runProcess(['openssl', 'genrsa', '-out', $privateKey, '2048']);

        // Get company name for the certificate
        $companyName = settings('company_name', 'BiznisBox');

        // Create self-signed certificate
        $this->runProcess([
            'openssl',
            'req',
            '-x509',
            '-new',
            '-key',
            $privateKey,
            '-out',
            $certificate,
            '-days',
            $days,
            '-subj',
            '/O=' . $companyName . '/CN=' . $companyName,
        ]);

        $this->runProcess([
            'openssl',
            'pkcs12',
            '-export',
            '-out',
            $pfx,
            '-inkey',
            $privateKey,
            '-in',
            $certificate,
            '-passout',
            'pass:' . $password,
        ]);

        file_put_contents($certDir . '/.cert_password', $password);

        // Save details to settings path without storage_path dependency
        $settingsData = [
            'document_signer_certificate_path' => '/certificate.pem',
            'document_signer_private_key_path' => '/private_key.pem',
            'document_signer_private_key_password' => $password,
        ];

        settings($settingsData, 'set');

        $this->info('✅ Certificate generated successfully:');
        $this->line('📄 certificate.pem');
        $this->line('🔑 private_key.pem');
        $this->line('📦 server-cert.p12');
        $this->line('🔐 Password: ' . $password);

        return Command::SUCCESS;
    }

    protected function runProcess(array $command)
    {
        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}
