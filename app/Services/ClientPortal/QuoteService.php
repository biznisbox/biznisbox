<?php

namespace App\Services\ClientPortal;

use App\Models\Quote;

class QuoteService
{
    public function getQuotes()
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());

        $quotes = Quote::where('payer_id', $partner_id)->orWhere('customer_id', $partner_id)->get();
        createActivityLog('retrieve', null, Quote::$modelName, 'Quote', auth()->id(), 'App\Models\User', 'client_portal');
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
            ->first()
            ?->makeHidden(['notes']);

        createActivityLog('retrieve', $quoteId, Quote::$modelName, 'Quote', auth()->id(), 'App\Models\User', 'client_portal');
        return $quote;
    }
}
