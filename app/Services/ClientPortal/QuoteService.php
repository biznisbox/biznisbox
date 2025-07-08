<?php

namespace App\Services\ClientPortal;

use App\Models\Quote;

class QuoteService
{
    public function getQuotes()
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());

        $quotes = Quote::where('payer_id', $partner_id)->orWhere('customer_id', $partner_id)->get();

        return $quotes;
    }

    public function getQuoteById($quoteId)
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());

        $quote = Quote::with(['items', 'paymentMethod', 'salesPerson'])
            ->where('id', $quoteId)
            ->where(function ($query) use ($partner_id) {
                $query->where('payer_id', $partner_id)->orWhere('customer_id', $partner_id);
            })
            ->first();

        // remove notes
        if ($quote) {
            $quote->notes = null;
        }

        return $quote;
    }
}
