<?php

namespace App\Console\Commands;

use App\Enum\ConsoleCommandEnum;
use Illuminate\Console\Command;

class ProcessSupportTicketImapMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = ConsoleCommandEnum::SEND_SUPPORT_TICKET_IMAP_MAILER->value;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and process support ticket emails via IMAP';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to process support ticket IMAP mails...');

        $imapIntegration = new \App\Integrations\SupportTicketImap();
        $imapIntegration->processMessages();

        $this->info('Finished processing support ticket IMAP mails.');
    }
}
