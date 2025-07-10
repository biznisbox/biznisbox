<?php

namespace App\Services\ClientPortal;

use App\Models\Partner;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getClientPortalDashboardData()
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());

        // Select number of not paid invoices
        $unpaidInvoices = DB::table('invoices')
            ->where('payer_id', $partner_id)
            ->orWhere('customer_id', $partner_id)
            ->where('status', '!=', 'paid')
            ->count();

        // number of support tickets
        $numberOfSupportTickets = DB::table('support_tickets')->where('partner_id', $partner_id)->count();

        // number of contracts
        $numberOfContracts = DB::table('contracts')
            ->select(DB::raw('COUNT(*) as contracts_count'))
            ->where('partner_id', $partner_id)
            ->first();

        $numberOfBills = DB::table('bills')->where('supplier_id', $partner_id)->count();

        $numberOfQuotes = DB::table('quotes')->where('payer_id', $partner_id)->orWhere('customer_id', $partner_id)->count();

        return [
            'unpaid_invoices' => $unpaidInvoices,
            'number_of_support_tickets' => $numberOfSupportTickets,
            'contracts_count' => $numberOfContracts ? $numberOfContracts->contracts_count : 0,
            'number_of_bills' => $numberOfBills,
            'number_of_quotes' => $numberOfQuotes,
            'partner' => Partner::with(['contacts', 'addresses'])
                ->where('id', $partner_id)
                ->first()
                ?->makeHidden(['notes', 'contacts.notes', 'addresses.notes']), // remove notes
        ];
    }
}
