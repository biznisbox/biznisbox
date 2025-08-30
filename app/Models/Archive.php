<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class Archive extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Archive';

    protected $table = 'archive';

    protected $fillable = [
        'number',
        'folder_id',
        'user_id',
        'partner_id',
        'storage_location_id',
        'connected_document_id',
        'connected_document_type',
        'document_type_id',
        'name',
        'type',
        'description',
        'file_name',
        'file_type',
        'file_size',
        'file_mime',
        'file_path',
        'file_hash_sha256',
        'file_hash_md5',
        'file_extension',
        'status',
        'visibility',
        'protection_level',
        'archived_until',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['download_link', 'preview_link'];

    public function generateTags(): array
    {
        return ['Archive'];
    }

    public function folder()
    {
        return $this->belongsTo(Category::class, 'folder_id');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function connectedDocument()
    {
        return $this->morphTo('connected_document');
    }

    public function storageLocation()
    {
        return $this->belongsTo(Department::class, 'storage_location_id');
    }

    public function documentType()
    {
        return $this->belongsTo(Category::class, 'document_type_id');
    }

    public function getDownloadLinkAttribute()
    {
        return URL::SignedRoute('downloadDocument', ['id' => $this->id]);
    }

    public function getPreviewLinkAttribute()
    {
        return URL::SignedRoute('previewDocument', ['id' => $this->id]);
    }

    public function getTrashedDocuments()
    {
        return $this->onlyTrashed()->get();
    }

    public function getDocument($id)
    {
        $document = $this->with('connectedDocument', 'partner', 'storageLocation', 'documentType')->find($id);
        createActivityLog('retrieve', $id, Archive::$modelName, 'Archive');
        return $document;
    }

    public function getDocumentsByFolder($folderId = null)
    {
        // Get trashed documents
        if ($folderId == 'trash') {
            createActivityLog('retrieve', null, Archive::$modelName, 'Archive');
            return $this->getTrashedDocuments();
        }
        // Get all documents
        if ($folderId == 'all') {
            createActivityLog('retrieve', null, Archive::$modelName, 'Archive');
            return $this->with('connectedDocument', 'partner', 'storageLocation', 'documentType')->get();
        }
        // Get documents without folder
        if ($folderId == 'null' || $folderId == null) {
            createActivityLog('retrieve', null, Archive::$modelName, 'Archive');
            return $this->with('connectedDocument', 'partner', 'storageLocation', 'documentType')->whereNull('folder_id')->get();
        }
        // Get documents by folder id
        createActivityLog('retrieve', null, Archive::$modelName, 'Archive');
        return $this->with('connectedDocument', 'partner', 'storageLocation', 'documentType')->where('folder_id', $folderId)->get();
    }

    public function deleteDocument($id)
    {
        $document = $this->find($id);
        if (!$document) {
            return false;
        }
        $document->delete();
        sendWebhookForEvent('archive:document_deleted', ['id' => $id]);
        return true;
    }

    public function restoreDocument($id)
    {
        $document = $this->withTrashed()->find($id);
        if (!$document) {
            return [
                'error' => __('responses.item_not_restored'),
                'status' => 400,
            ];
        }
        $document->restore();
        sendWebhookForEvent('archive:document_restored', ['id' => $id]);
        return true;
    }

    public static function getArchiveNumber()
    {
        return generateNextNumber(settings('archive_number_format'), 'archive');
    }

    /**
     * Update status of document cron
     */
    public function updateDocumentStatusCron()
    {
        $documents = $this->where('status', '!=', 'archived')->get();
        foreach ($documents as $document) {
            if ($document->archived_until < now()) {
                $document->update(['status' => 'archived']);
            }
        }
    }
}
