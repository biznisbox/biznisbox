<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;

class DocumentsController extends Controller
{
    protected $documentsModel;

    public function __construct(Documents $documentsModel)
    {
        $this->documentsModel = $documentsModel;
    }

    public function getDocuments(Request $request)
    {
        $folder_id = $request->folder_id ?? null;
        $documents = $this->documentsModel->getDocuments($folder_id);

        if ($documents) {
            return api_response($documents, __('response.document.get_success'));
        }
        return api_response(null, __('response.document.get_failed'), 400);
    }

    public function getDocument(Request $request)
    {
        $document_id = $request->document_id;
        $document = $this->documentsModel->getDocument($document_id);

        if ($document) {
            return api_response($document, __('response.document.get_success'));
        }
        return api_response(null, __('response.document.not_found'), 404);
    }

    public function createDocument(Request $request)
    {
        $document = $this->documentsModel->createDocument($request);
        if ($document) {
            return api_response($document, __('response.document.create_success'), 201);
        }
        return api_response(null, __('response.document.create_failed'), 400);
    }

    public function deleteDocument(Request $request)
    {
        $document_id = $request->document_id;
        $document = $this->documentsModel->deleteDocument($document_id);

        if ($document) {
            return api_response(null, __('response.document.delete_success'));
        }
        return api_response(null, __('response.document.delete_failed'), 400);
    }

    public function downloadDocument(Request $request)
    {
        $document_id = $request->document_id;
        $document = $this->documentsModel->downloadDocument($document_id);

        if ($document) {
            return $document;
        }
        return api_response(null, __('response.document.not_found'), 400);
    }

    public function previewDocument(Request $request)
    {
        $document_id = $request->document_id;
        $document = $this->documentsModel->previewDocument($document_id);

        if ($document) {
            return $document;
        }
        return api_response(null, __('response.document.not_found'), 400);
    }

    // Folders operations
    public function getFolders()
    {
        $folders = $this->documentsModel->getFolders();

        if ($folders) {
            return api_response($folders, __('response.folders.get_success'));
        }
        return api_response(null, __('response.folders.not_found'), 400);
    }

    public function createFolder(Request $request)
    {
        $parent_folder_id = $request->parent_folder_id ?? null;
        $name = $request->name;
        $folder = $this->documentsModel->createFolder($parent_folder_id, $name);

        if ($folder) {
            return api_response($folder, __('response.document.create_success'), 201);
        }
        return api_response(null, __('response.document.create_failed'), 400);
    }

    public function deleteFolder(Request $request)
    {
        $path = $request->path;
        $folder = $this->documentsModel->deleteFolder($path);

        if ($folder) {
            return api_response(null, __('response.document.delete_success'));
        }
        return api_response(null, __('response.document.delete_failed'), 400);
    }
}
