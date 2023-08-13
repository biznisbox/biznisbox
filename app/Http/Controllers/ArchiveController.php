<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archive;

class ArchiveController extends Controller
{
    protected $archiveModel;

    public function __construct(Archive $archiveModel)
    {
        $this->archiveModel = $archiveModel;
    }

    public function getDocuments(Request $request)
    {
        $folder_id = $request->folder_id ?? null;
        $documents = $this->archiveModel->getDocuments($folder_id);

        if ($documents) {
            return api_response($documents, __('response.archive.get_success'));
        }
        return api_response(null, __('response.archive.get_failed'), 400);
    }

    public function getDocument(Request $request)
    {
        $document_id = $request->document_id;
        $document = $this->archiveModel->getDocument($document_id);

        if ($document) {
            return api_response($document, __('response.archive.get_success'));
        }
        return api_response(null, __('response.archive.not_found'), 404);
    }

    public function createDocument(Request $request)
    {
        $document = $this->archiveModel->createDocument($request);
        if ($document) {
            return api_response($document, __('response.archive.create_success'), 201);
        }
        return api_response(null, __('response.archive.create_failed'), 400);
    }

    public function updateDocument(Request $request)
    {
        $document_id = $request->id;
        $data = $request->all();
        $document = $this->archiveModel->updateDocument($document_id, $data);

        if ($document) {
            return api_response($document, __('response.archive.update_success'));
        }
        return api_response(null, __('response.archive.update_failed'), 400);
    }

    public function deleteDocument(Request $request)
    {
        $document_id = $request->document_id;
        $document = $this->archiveModel->deleteDocument($document_id);

        if ($document) {
            return api_response(null, __('response.archive.delete_success'));
        }
        return api_response(null, __('response.archive.delete_failed'), 400);
    }

    public function downloadDocument(Request $request)
    {
        $document_id = $request->document_id;
        $document = $this->archiveModel->downloadDocument($document_id);

        if ($document) {
            return $document;
        }
        return api_response(null, __('response.archive.not_found'), 400);
    }

    public function previewDocument(Request $request)
    {
        $document_id = $request->document_id;
        $document = $this->archiveModel->previewDocument($document_id);

        if ($document) {
            return $document;
        }
        return api_response(null, __('response.archive.not_found'), 400);
    }

    // Folders operations
    public function getFolders()
    {
        $folders = $this->archiveModel->getFolders();

        if ($folders) {
            return api_response($folders, __('response.folders.get_success'));
        }
        return api_response(null, __('response.folders.not_found'), 400);
    }

    public function getFolder($id)
    {
        $folder = $this->archiveModel->getFolder($id);

        if ($folder) {
            return api_response($folder, __('response.folders.get_success_folder'));
        }

        return api_response(null, __('response.folders.not_found_folder'), 400);
    }

    public function createFolder(Request $request)
    {
        $parent_folder_id = $request->parent_folder_id ?? null;
        $name = $request->name;
        $folder = $this->archiveModel->createFolder($parent_folder_id, $name);

        if ($folder) {
            return api_response($folder, __('response.archive.create_success_folder'), 201);
        }
        return api_response(null, __('response.archive.create_failed_folder'), 400);
    }

    public function updateFolder(Request $request)
    {
        $folder_id = $request->id;
        $data = $request->all();
        $folder = $this->archiveModel->updateFolder($folder_id, $data);

        if ($folder) {
            return api_response($folder, __('response.archive.update_success_folder'));
        }
        return api_response(null, __('response.archive.update_failed_folder'), 400);
    }

    public function deleteFolder(Request $request)
    {
        $folder_id = $request->folder_id;
        $folder = $this->archiveModel->deleteFolder($folder_id);

        if ($folder) {
            return api_response(null, __('response.archive.delete_success_folder'));
        }
        return api_response(null, __('response.archive.delete_failed_folder'), 400);
    }
}
