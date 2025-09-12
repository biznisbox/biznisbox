<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SupportTicketService;

/**
 * @group Support Tickets
 *
 * APIs for managing support tickets
 * @authenticated
 */
class SupportTicketController extends Controller
{
    protected $supportTicketService;

    public function __construct(SupportTicketService $supportTicketService)
    {
        $this->supportTicketService = $supportTicketService;
    }

    /**
     * Get all support tickets
     *
     * @return array $tickets Support tickets
     */
    public function getTickets()
    {
        $tickets = $this->supportTicketService->getTickets();
        if ($tickets) {
            return apiResponse($tickets, __('responses.data_retrieved_successfully'));
        }
        return apiResponse(null, __('responses.item_not_found'), 400);
    }

    /**
     * Get support ticket by id
     *
     * @param  string  $id id of the support ticket
     * @return array $ticket Support ticket
     */
    public function getTicket($id)
    {
        $ticket = $this->supportTicketService->getTicket($id);
        if ($ticket) {
            return apiResponse($ticket, __('responses.data_retrieved_successfully'));
        }
        return apiResponse(null, __('responses.item_not_found_with_id'), 404);
    }

    /**
     * Get support ticket contents by id
     *
     * @param  string  $id id of the support ticket
     * @return array $contents Support ticket contents
     */
    public function getTicketContents($id)
    {
        $contents = $this->supportTicketService->getTicketContents($id);
        if ($contents) {
            return apiResponse($contents, __('responses.data_retrieved_successfully'));
        }
        return apiResponse(null, __('responses.item_not_found'), 400);
    }

    /**
     * Create a new support ticket
     *
     * @param  object  $request data from the form
     * @return array $ticket Support ticket
     */
    public function createTicket(Request $request)
    {
        $data = $request->all();
        $ticket = $this->supportTicketService->createTicket($data);
        if ($ticket) {
            return apiResponse($ticket, __('responses.item_created_successfully'));
        }
        return apiResponse(null, __('responses.item_not_created'), 400);
    }

    /**
     * Update support ticket
     *
     * @param  object  $request data from the form
     * @param  string  $id id of the support ticket
     * @return array $ticket Support ticket
     */
    public function updateTicket(Request $request, $id)
    {
        $data = $request->all();
        $ticket = $this->supportTicketService->updateSupportTicket($id, $data);
        if ($ticket) {
            return apiResponse($ticket, __('responses.item_updated_successfully'));
        }
        return apiResponse(null, __('responses.item_not_updated'), 400);
    }

    /**
     * Delete a support ticket
     *
     * @param  string  $id id of the support ticket
     * @return array $ticket Support ticket
     */
    public function deleteTicket($id)
    {
        $ticket = $this->supportTicketService->deleteSupportTicket($id);
        if ($ticket) {
            return apiResponse($ticket, __('responses.item_deleted_successfully'));
        }
        return apiResponse(null, __('responses.item_not_deleted'), 400);
    }

    /**
     * Get all support ticket messages
     *
     * @param  string  $id id of the support ticket
     * @return array $messages Support ticket messages
     */
    public function getTicketMessages($id)
    {
        $messages = $this->supportTicketService->getTicketMessages($id);
        if ($messages) {
            return apiResponse($messages, __('responses.data_retrieved_successfully'));
        }
        return apiResponse(null, __('responses.item_not_found'), 400);
    }

    /**
     * Create a new support ticket message
     *
     * @param  string  $id id of the support ticket
     * @return array $message Support ticket message
     */
    public function createTicketMessage(Request $request, $id)
    {
        $data = $request->all();
        $message = $this->supportTicketService->createTicketMessage($id, $data);
        if ($message) {
            return apiResponse($message, __('responses.item_created_successfully'));
        }
        return apiResponse(null, __('responses.item_not_created'), 400);
    }

    /**
     * Update support ticket message
     *
     * @param  string  $id id of the support ticket
     * @return array $message Support ticket message
     */
    public function updateTicketMessage(Request $request, $id)
    {
        $data = $request->all();
        $message = $this->supportTicketService->updateTicketMessage($id, $data);
        if ($message) {
            return apiResponse($message, __('responses.item_updated_successfully'));
        }
        return apiResponse(null, __('responses.item_not_updated'), 400);
    }

    /**
     * Delete support ticket message
     *
     * @param  string  $id id of the support ticket
     * @return array $message Support ticket message
     */
    public function deleteTicketMessage($id)
    {
        $message = $this->supportTicketService->deleteTicketMessage($id);
        if ($message) {
            return apiResponse($message, __('responses.item_deleted_successfully'));
        }
        return apiResponse(null, __('responses.item_not_deleted'), 400);
    }

    /**
     * Get support ticket number
     *
     * @return void
     */
    public function getTicketNumber()
    {
        $number = $this->supportTicketService->getTicketNumber();
        if ($number) {
            return apiResponse($number, __('responses.data_retrieved_successfully'));
        }
        return apiResponse(null, __('responses.item_not_found'), 400);
    }

    /**
     * Share support ticket
     * @param  string  $id id of the support ticket
     * @return array $ticket Support ticket
     */
    public function shareTicket($id)
    {
        $ticket = $this->supportTicketService->shareTicket($id);
        if ($ticket) {
            return apiResponse($ticket, __('responses.item_shared_successfully'));
        }
        return apiResponse(null, __('responses.item_not_shared'), 400);
    }

    /**
     * Send ticket notification to contact
     *
     * @param  string  $id id of the support ticket
     * @return array $ticket Support ticket
     */
    public function sendTicketNotificationToContact($id)
    {
        $ticket = $this->supportTicketService->sendTicketNotificationToContact($id);

        if ($ticket) {
            return apiResponse($ticket, __('responses.notification_sent_successfully'));
        }
        return apiResponse(null, __('responses.notification_not_sent'), 400);
    }
}
