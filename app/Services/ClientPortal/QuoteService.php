<?php

namespace App\Services\ClientPortal;

use App\Models\Quote;
use App\Models\User;

class QuoteService
{
    public function getQuotes()
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());

        $quotes = Quote::where('payer_id', $partner_id)->orWhere('customer_id', $partner_id)->get();
        createActivityLog('retrieve', null, Quote::$modelName, 'Quote', auth()->id(), User::$modelName, 'client_portal');
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

        createActivityLog('retrieve', $quoteId, Quote::$modelName, 'Quote', auth()->id(), User::$modelName, 'client_portal');
        return $quote;
    }

    public function acceptRejectQuote($quoteId, $action)
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());

        $quote = Quote::where('id', $quoteId)
            ->where(function ($query) use ($partner_id) {
                $query->where('payer_id', $partner_id)->orWhere('customer_id', $partner_id);
            })
            ->first();

        if (!$quote) {
            return null;
        }

        if ($quote->status === 'accepted' || $quote->status === 'rejected') {
            return [
                'error' => __('responses.already_accepted_rejected'),
            ];
        }

        if ($action === 'accept') {
            $quote->status = 'accepted';
        } elseif ($action === 'reject') {
            $quote->status = 'rejected';
        } else {
            return null;
        }

        $quote->save();

        createActivityLog($action, $quoteId, Quote::$modelName, 'Quote', auth()->id(), User::$modelName, 'client_portal');
        return $quote;
    }
}
