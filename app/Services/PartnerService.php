<?php

namespace App\Services;

use App\Models\Partner;
use App\Models\PartnerActivity;
use App\Models\PartnerContact;
use App\Mail\Client\SendPartnerMessage;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\Client\ClientPortalNotification;
use App\Integrations\VatIdValidate;

class PartnerService
{
    private $partnerModel;
    private $vatIdValidator;
    private $partnerActivityModel;

    public function __construct()
    {
        $this->partnerModel = new Partner();
        $this->vatIdValidator = new VatIdValidate();
        $this->partnerActivityModel = new PartnerActivity();
    }

    public function getPartners($type = null)
    {
        // type can have comma separated values (customer, supplier, both)
        if ($type) {
            $type = explode(',', $type);
            $partners = $this->partnerModel->with('addresses', 'contacts')->whereIn('type', $type)->get();
        } else {
            $partners = $this->partnerModel->with('addresses', 'contacts')->get();
        }
        createActivityLog('retrieve', null, Partner::$modelName, 'Partner');
        return $partners;
    }

    public function getPartner($id)
    {
        return $this->partnerModel->getPartner($id);
    }

    public function createPartner($data)
    {
        return $this->partnerModel->createPartner($data);
    }

    public function updatePartner($id, $data)
    {
        return $this->partnerModel->updatePartner($id, $data);
    }

    public function deletePartner(string $id)
    {
        return $this->partnerModel->deletePartner($id);
    }

    public function getPartnerNumber()
    {
        return $this->partnerModel->getPartnerNumber();
    }

    public function getPartnersLimitedData($type = null)
    {
        return $this->partnerModel->getPartnersLimitedData($type);
    }

    public function createPartnerActivity($data)
    {
        return $this->partnerActivityModel->createPartnerActivity($data);
    }

    public function updatePartnerActivity($id, $data)
    {
        return $this->partnerActivityModel->updatePartnerActivity($id, $data);
    }

    public function deletePartnerActivity($id)
    {
        return $this->partnerActivityModel->deletePartnerActivity($id);
    }

    public function sendEmailToPartnerContact($partnerContactId, $subject, $message)
    {
        // Get partner contact
        $partnerContact = PartnerContact::find($partnerContactId);
        if (!$partnerContact) {
            return false;
        }

        if (!$partnerContact->email || !$partnerContact->name || filter_var($partnerContact->email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }

        // Get current user data to use as sender
        $user = auth()->user();
        $from_email = $user->email;
        $from_name = $user->first_name . ' ' . $user->last_name;

        // Send email
        setEmailConfig();
        $email = Mail::to($partnerContact->email, $partnerContact->name)->send(
            new SendPartnerMessage($from_email, $from_name, $subject, $message),
        );
        saveSendEmailLog('SendPartnerMessage', 'partner_contact', $partnerContact->email, 'sent', 'user', auth()->id());

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

    public function addPartnerContactToClientPortal($partnerContactId)
    {
        $partnerContact = PartnerContact::find($partnerContactId);
        if (!$partnerContact) {
            return false;
        }

        if (!$partnerContact->email || !$partnerContact->name || filter_var($partnerContact->email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }

        // If user is already in client portal, return false
        if ($partnerContact->client_portal) {
            return false;
        }
        // Create user
        $password = generateRandomPassword(15);
        $user = new User();
        $user = $user->createUser([
            'first_name' => $partnerContact->name,
            'last_name' => '',
            'email' => $partnerContact->email,
            'password' => $password,
            'active' => true,
            'language' => 'en',
            'timezone' => 'UTC',
            'role' => 'client',
        ]);

        if (!$user) {
            return false;
        }

        $user = User::where('email', $partnerContact->email)->first();

        // Update partner contact
        $partnerContact->client_portal = true;
        $partnerContact->user_id = $user->id;
        $partnerContact->save();

        setEmailConfig();
        // Send notification email
        $email = Mail::to($partnerContact->email, $partnerContact->name)->send(
            new ClientPortalNotification($partnerContact->partner, $password, $partnerContact),
        );
        saveSendEmailLog('ClientPortalNotification', 'partner_contact', $partnerContact->email, 'sent', 'user', auth()->id());

        createActivityLog('addPartnerContactToClientPortal', $partnerContact->partner_id, 'App\Models\Partner', 'Partner');

        return true;
    }

    public function validatePartnerVatID($vatNumber)
    {
        return $this->vatIdValidator->validateVatNumber($vatNumber);
    }
}
