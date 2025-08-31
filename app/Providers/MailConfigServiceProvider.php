<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('settings')) {
            $mail = DB::table('settings')->where('key', 'like', 'mail_%')->get()->pluck('value', 'key');
            if ($mail && $mail->count() > 0) {
                $config = [
                    'default' => $mail->get('mail_mailer') ?? 'log',
                    'mailers' => [
                        'smtp' => [
                            'transport' => 'smtp',
                            'host' => $mail->get('mail_host'),
                            'port' => $mail->get('mail_port'),
                            'encryption' => $mail->get('mail_encryption'),
                            'username' => $mail->get('mail_username'),
                            'password' => $mail->get('mail_password'),
                        ],
                        'sendmail' => [
                            'transport' => 'sendmail',
                            'path' => $mail->get('mail_sendmail_path'),
                        ],
                        'log' => [
                            'transport' => 'log',
                            'channel' => 'mail',
                        ],
                    ],
                    'from' => ['address' => $mail->get('mail_from_address'), 'name' => $mail->get('mail_from_name')],
                ];
                Config::set([
                    'mail' => $config,
                ]);
            }
        }
    }
}
