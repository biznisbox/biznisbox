<?php

namespace App\Services;

use App\Models\Partner;
use App\Models\PartnerActivity;
use App\Models\PartnerContact;
use App\Mail\Client\SendPartnerMessage;
use Illuminate\Support\Facades\Mail;

class PartnerService
{
    private $partnerModel;
    public function __construct()
    {
        $this->partnerModel = new Partner();
    }

    public function getPartners($type = null)
    {
        $partners = $this->partnerModel->getPartners($type);
        return $partners;
    }

    public function getPartner($id)
    {
        $partner = $this->partnerModel->getPartner($id);
        return $partner;
    }

    public function createPartner($data)
    {
        $partner = $this->partnerModel->createPartner($data);
        return $partner;
    }

    public function updatePartner($id, $data)
    {
        $partner = $this->partnerModel->updatePartner($id, $data);
        return $partner;
    }

    public function deletePartner(string $id)
    {
        $partner = $this->partnerModel->deletePartner($id);
        return $partner;
    }

    public function getPartnerNumber()
    {
        $partner = $this->partnerModel->getPartnerNumber();
        return $partner;
    }

    public function getPartnersLimitedData($type = null)
    {
        $partners = $this->partnerModel->getPartnersLimitedData($type);
        return $partners;
    }

    public function createPartnerActivity($data)
    {
        $partnerActivity = new PartnerActivity();
        $partnerActivity = $partnerActivity->createPartnerActivity($data);
        return $partnerActivity;
    }

    public function updatePartnerActivity($id, $data)
    {
        $partnerActivity = new PartnerActivity();
        $partnerActivity = $partnerActivity->updatePartnerActivity($id, $data);
        return $partnerActivity;
    }

    public function deletePartnerActivity($id)
    {
        $partnerActivity = new PartnerActivity();
        $partnerActivity = $partnerActivity->deletePartnerActivity($id);
        return $partnerActivity;
    }

    public function sendEmailToPartnerContact($partnerContactId, $subject, $message)
    {
        // Get partner contact
        $partnerContact = PartnerContact::find($partnerContactId);
        if (!$partnerContact) {
            return false;
        }

        // Get current user data to use as sender
        $user = auth()->user();
        $from_email = $user->email;
        $from_name = $user->first_name . ' ' . $user->last_name;

        // Send email
        $email = Mail::to($partnerContact->email, $partnerContact->name)->send(
            new SendPartnerMessage($from_email, $from_name, $subject, $message)
        );

        if (!$email) {
            return false;
        }

        // Create partner activity
        $data = [
            'partner_id' => $partnerContact->partner_id,
            'partner_contact_id' => $partnerContact->id,
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s'),
            'content' => $message,
            'subject' => $subject,
            'status' => 'completed',
            'priority' => 'normal',
            'type' => 'email',
            'employee_id' => getEmployeeIdFromUserId($user->id),
        ];
        $partnerActivity = $this->createPartnerActivity($data);
        if (!$partnerActivity) {
            return false;
        }
        return true;
    }
}
