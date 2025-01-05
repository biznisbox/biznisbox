<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArchiveService;

/**
 * @group Archive
 *
 * APIs for managing archive
 */
class ArchiveController extends Controller
{
    private $archiveService;

    public function __construct(ArchiveService $archiveService)
    {
        $this->archiveService = $archiveService;
    }

    /**
     * Get all documents
     * 
     * @return array $documents All documents
     */
    public function getDocuments(Request $request)
    {
        $folderId = $request->folder_id;
        $documents = $this->archiveService->getDocuments($folderId);
        if (!$documents) {
            return api_response($documents, __('responses.item_not_found'), 404);
        }
        return api_response($documents, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Get document by id
     * 
     * @param  string  $id id of the document
     * @return array $document document
     */
    public function getDocument($id)
    {
        $document = $this->archiveService->getDocument($id);
        if (!$document) {
            return api_response($document, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($document, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Create a new document
     * 
     * @param  object  $request data from the form (name, file, folder_id)
     * @return array $document document
     */
    public function createDocument(Request $request)
    {
        $document = $this->archiveService->createDocument($request);
        if (!$document) {
            return api_response($document, __('responses.item_not_created'), 400);
        }
        return api_response($document, __('responses.item_created_successfully'), 200);
    }

    /**
     * Update a document
     * 
     * @param  object  $request data from the form (name, file, folder_id)
     * @param  string  $id id of the document
     * @return array $document document
     */
    public function updateDocument(Request $request, $id)
    {
        $document = $this->archiveService->updateDocument($request, $id);
        if (!$document) {
            return api_response($document, __('responses.item_not_updated'), 400);
        }
        return api_response($document, __('responses.item_updated_successfully'), 200);
    }

    /**
     * Delete a document
     * 
     * @param  string  $id id of the document
     * @return array $document document
     */
    public function deleteDocument($id)
    {
        $document = $this->archiveService->deleteDocument($id);
        if (!$document) {
            return api_response($document, __('responses.item_not_deleted'), 400);
        }
        return api_response($document, __('responses.item_deleted_successfully'), 200);
    }

    /**
     * Restore a document
     * 
     * @param  string  $id id of the document
     * @return array $document document
     */
    public function restoreDocument($id)
    {
        $document = $this->archiveService->restoreDocument($id);
        if (!$document) {
            return api_response($document, __('responses.item_not_restored'), 400);
        }
        return api_response($document, __('responses.item_restored_successfully'), 200);
    }

    /**
     * Delete a document permanently
     * 
     * @param  string  $id id of the document
     * @return array $document document
     */
    public function deleteDocumentPermanently($id)
    {
        $document = $this->archiveService->deleteDocumentPermanently($id);
        if (!$document) {
            return api_response($document, __('responses.item_not_deleted'), 400);
        }
        return api_response($document, __('responses.item_deleted_successfully'), 200);
    }

    /**
     * Download a document
     * 
     * @param  string  $id id of the document
     * @return array $document document
     */
    public function downloadDocument($id)
    {
        if (!request()->hasValidSignatureWhileIgnoring(['lang'])) {
            return api_response(null, __('responses.invalid_signature'), 400);
        }
        $document = $this->archiveService->downloadDocument($id);
        if (!$document) {
            return api_response($document, __('responses.item_not_downloaded'), 400);
        }
        return $document;
    }

    /**
     * Preview a document
     * 
     * @param  string  $id id of the document
     * @return array $document document
     */
    public function previewDocument($id)
    {
        if (!request()->hasValidSignatureWhileIgnoring(['lang'])) {
            return api_response(null, __('responses.invalid_signature'), 400);
        }
        $document = $this->archiveService->previewDocument($id);
        if (!$document) {
            return api_response($document, __('responses.item_not_previewed'), 400);
        }
        return $document;
    }

    /**
     * Move a document
     * 
     * @param  object  $request data from the form (folder_id)
     * @param  string  $id id of the document
     * @return array $document document
     */
    public function moveDocument(Request $request, $id)
    {
        $document = $this->archiveService->moveDocument($request, $id);
        if (!$document) {
            return api_response($document, __('responses.item_not_moved'), 400);
        }
        return api_response($document, __('responses.item_moved_successfully'), 200);
    }
}
