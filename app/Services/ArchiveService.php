<?php

namespace App\Services;

use App\Models\Archive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchiveService
{
    private $archiveModel;

    public function __construct()
    {
        $this->archiveModel = new Archive();
    }

    public function getDocuments($folderId = null)
    {
        if ($folderId) {
            if ($folderId == 'trash') {
                $documents = $this->archiveModel->getTrashedDocuments();
            } else {
                $documents = $this->archiveModel->getDocumentsByFolder($folderId);
            }
        } else {
            $documents = $this->archiveModel->getDocumentsByFolder();
        }
        createActivityLog('retrieve', null, 'App\Models\Archive', 'Archive');
        return $documents;
    }

    public function getDocument($id)
    {
        $document = $this->archiveModel->getDocument($id);
        return $document;
    }

    public function createDocument($request)
    {
        // Check if is there a file in the request
        if (
            $request->hasFile('file') &&
            $request->file('file')->isValid() &&
            $request->file('file')->getSize() > 0 &&
            $request->folder_id !== 'trash'
        ) {
            // Check if the folder_id is null - fix from the frontend
            if ($request->folder_id === 'null') {
                $request->folder_id = null;
            }
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $diskFileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $fileStore = $file->storeAs('archive/' . $diskFileName);

            if ($fileStore) {
                $document = $this->archiveModel->create([
                    'number' => Archive::getArchiveNumber(),
                    'folder_id' => $request->folder_id ?? null,
                    'name' => $fileName,
                    'file_name' => $fileName,
                    'file_size' => $file->getSize(),
                    'file_mime' => $file->getClientMimeType(),
                    'file_path' => $diskFileName,
                    'file_hash_sha256' => hash_file('sha256', $file),
                    'file_hash_md5' => hash_file('md5', $file),
                    'file_extension' => $file->getClientOriginalExtension(),
                    'status' => 'active',
                    'type' => 'document',
                    'description' => $request->description ?? null,
                    'partner_id' => $request->partner_id ?? null,
                    'connected_document_id' => $request->connected_document_id ?? null,
                    'connected_document_type' => $request->connected_document_type ?? 'App\Models\Archive',
                    'user_id' => auth()->user()->id,
                    'visibility' => 'private',
                    'protection_level' => $request->protection_level ?? 'internal',
                    'storage_location_id' => $request->storage_location_id ?? null,
                    'document_type_id' => $request->document_type_id ?? null,
                ]);
                if ($document) {
                    sendWebhookForEvent('archive:document_created', $document->toArray());
                    incrementLastItemNumber('archive', settings('archive_number_format'));
                    return $document;
                }
                Storage::delete('archive/' . $diskFileName);
                return false;
            }
            Storage::delete('archive/' . $diskFileName);
            return false;
        }
    }

    public function updateDocument($request, $id)
    {
        $document = $this->archiveModel->find($id);

        if ($document && $request->name && !Str::contains($request->name, $document->file_extension)) {
            $request->name .= '.' . $document->file_extension;
        }

        if ($document) {
            $document->update([
                'folder_id' => $request->folder_id ?? $document->folder_id,
                'name' => $request->name ?? $document->name,
                'type' => $request->type ?? $document->type,
                'description' => $request->description ?? $document->description,
                'status' => $request->status,
                'partner_id' => $request->partner_id,
                'connected_document_id' => $request->connected_document_id,
                'connected_document_type' => $request->connected_document_type,
                'visibility' => $request->visibility,
                'protection_level' => $request->protection_level,
                'storage_location_id' => $request->storage_location_id,
                'document_type_id' => $request->document_type_id,
            ]);
            sendWebhookForEvent('archive:document_updated', $document->toArray());
            return $document;
        }
        return false;
    }

    public function deleteDocument($id)
    {
        $document = $this->archiveModel->deleteDocument($id);
        return $document;
    }

    public function restoreDocument($id)
    {
        $document = $this->archiveModel->restoreDocument($id);
        return $document;
    }

    public function deleteDocumentPermanently($id)
    {
        $document = $this->archiveModel->find($id);
        if ($document) {
            Storage::delete('archive/' . $document->file_path);
            $document->forceDelete();
            return $document;
        }
        return false;
    }

    public function downloadDocument($id)
    {
        $document = $this->archiveModel->find($id);
        if ($document) {
            $file = Storage::get('archive/' . $document->file_path);
            createActivityLog('download', $id, 'App\Models\Archive', 'Archive');
            return response($file, 200, [
                'Content-Type' => $document->file_mime,
                'Content-Disposition' => 'attachment; filename="' . $document->file_name . '"',
                'Content-Length' => $document->file_size,
                'Content-Transfer-Encoding' => 'binary',
                'X-Mime-Type' => $document->file_mime,
            ]);
        }
        return false;
    }

    public function previewDocument($id)
    {
        $document = $this->archiveModel->find($id);
        if ($document) {
            $file = Storage::get('archive/' . $document->file_path);
            createActivityLog('preview', $id, 'App\Models\Archive', 'Archive');
            return response($file, 200, [
                'Content-Type' => $document->file_mime,
                'Content-Disposition' => 'inline; filename="' . $document->file_name . '"',
                'Content-Length' => $document->file_size,
                'Content-Transfer-Encoding' => 'binary',
                'X-Mime-Type' => $document->file_mime,
            ]);
        }
        return false;
    }

    public function moveDocument($request, $id)
    {
        // Get the folder_id from the array key
        $folderId = array_keys($request->folder_id)[0];

        if ($folderId === 'undefined') {
            $folderId = null;
        }

        if ($folderId === 'trash') {
            return $this->deleteDocument($id);
        }

        $document = $this->archiveModel->find($id);

        if ($document) {
            $document->update([
                'folder_id' => $folderId,
            ]);
            sendWebhookForEvent('archive:document_moved', $document->toArray());
            return $document;
        }
        return false;
    }
}
