<?php

namespace App\Services\ClientPortal;

use App\Models\Partner;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getPartnerDashboardData()
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());

        // Select number of not paid invoices
        $notPaidInvoices = DB::table('invoices')
            ->where('payer_id', $partner_id)
            ->orWhere('customer_id', $partner_id)
            ->where('status', '!=', 'paid')
            ->count();

        // number of support tickets
        $numberOfSupportTickets = DB::table('support_tickets')->where('partner_id', $partner_id)->count();

        return [
            'not_paid_invoices' => $notPaidInvoices,
            'number_of_support_tickets' => $numberOfSupportTickets,
        ];
    }
}
