<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;

class DocumentController extends Controller
{
    protected $documentModel;
    public function __construct(Documents $documentModel)
    {
        $this->documentModel = $documentModel;
    }

    public function getDocuments()
    {
        $documents = $this->documentModel->getDocuments();
        return api_response($documents, __('response.document.get_success'), 200);
    }

    public function getDocument($id)
    {
        $documents = $this->documentModel->getDocument($id);
        if ($documents) {
            return api_response($documents, __('response.document.get_success'), 200);
        }
        return api_response(null, __('response.document.get_error'), 500);
    }

    public function createDocument(Request $request)
    {
        $document = $this->documentModel->createDocument($request->all());

        if ($document) {
            return api_response($document, __('response.document.create_success'));
        }
        return api_response(null, __('response.document.create_error'), 500);
    }

    public function updateDocument(Request $request, $id)
    {
        $document = $this->documentModel->updateDocument($request->all(), $id);

        if ($document) {
            return api_response($document, __('response.document.update_success'));
        }
        return api_response(null, __('response.document.update_error'), 500);
    }

    public function deleteDocument($id)
    {
        $document = $this->documentModel->deleteDocument($id);

        if ($document) {
            return api_response(null, __('response.document.delete_success'));
        }
        return api_response(null, __('response.document.delete_error'), 500);
    }

    public function getDocumentNumber()
    {
        $document = $this->documentModel->getDocumentNumber();
        return $document;
    }

    public function getDocumentPdf(Request $request)
    {
        $document = $this->documentModel->getDocumentPdf($request->id, $request->type);

        if ($document) {
            return $document;
        }
        return api_response(null, __('response.document.get_error'), 500);
    }
}
