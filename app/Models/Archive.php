<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Category;
use Illuminate\Support\Str;

class Archive extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'archive';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'file_name',
        'file_type',
        'file_size',
        'file_hash_sha256',
        'file_hash_md5',
        'file_path',
        'file_mime',
    ];
    protected $dates = ['deleted_at'];

    protected $hidden = ['file_hash_sha256', 'file_hash_md5', 'file_path', 'deleted_at'];

    public function generateTags(): array
    {
        return ['Document'];
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Document Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Create a new document
     * @param Request $request
     * @return Document
     */
    public function createDocument($request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $diskFileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $fileStore = $file->storeAs('documents/' . $diskFileName);

            if (!$fileStore) {
                Storage::delete('documents/' . $diskFileName); // Delete the file if it was created but not stored
                DB::rollBack();
                return false;
            }

            if ($request->folder_id == 'null') {
                $request->folder_id = null;
            }

            $document = $this->create([
                'category_id' => $request->folder_id,
                'name' => $fileName,
                'description' => $request->description,
                'file_name' => $fileName,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'file_mime' => $file->getClientMimeType(),
                'file_hash_sha256' => hash_file('sha256', $file),
                'file_hash_md5' => hash_file('md5', $file),
                'file_path' => $diskFileName,
            ]);
            activity_log(user_data()->data->id, 'create document', $document->id, 'Document', $document->name, null, null);
            return true;
        }
    }

    /**
     * Update a document
     * @param uuid document_id UUID of the document to update
     * @param array $data Array of data to update
     * @return bool True if updated, false if not found
     */
    public function updateDocument($document_id, $data)
    {
        $document = $this->where('id', $document_id)->first();

        if ($document) {
            $document->name = $data['name'];
            $document->description = $data['description'];
            $document->save();
            return true;
        }
        return false;
    }

    /**
     * Delete a document (soft delete)
     * @param uuid $document_id UUID of the document
     * @return bool True if deleted, false if not found
     */
    public function deleteDocument($document_id)
    {
        try {
            $document = $this->where('id', $document_id)->first();
            if ($document) {
                $document->delete();
                activity_log(user_data()->data->id, 'delete document', $document->id, 'Document');
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get a document
     * @param UUID $document_id  of the document
     * @return object|bool Document object or false if not found
     */
    public function getDocument($document_id)
    {
        try {
            $document = $this->where('id', $document_id)->first();
            if ($document) {
                $document->preview_url = URL::signedRoute('documents.preview', ['document_id' => $document->id]);
                $document->download_url = URL::signedRoute('documents.download', ['document_id' => $document->id]);
                activity_log(user_data()->data->id, 'get document', $document->id, 'Document', 'Document');
                return $document;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Preview a document by id and return the file
     * @param $id UUID of the document
     * @return object|bool Document object or false if not found
     */
    public function previewDocument($id)
    {
        $document = $this->where('id', $id)->first();

        if ($document) {
            $file = Storage::get('documents/' . $document->file_path);

            return response($file, 200)
                ->header('Content-Type', $document->file_mime)
                ->header('Content-Length', $document->file_size)
                ->header('Content-Disposition', 'inline; filename="' . $document->file_name . '"');
        }
        return false;
    }

    /**
     * Download a document by id and return the file
     * @param $id UUID of the document
     * @return object|bool Document object or false if not found
     */
    public function downloadDocument($id)
    {
        $document = $this->where('id', $id)->first();

        if ($document) {
            $file = Storage::get('documents/' . $document->file_path);

            return response($file, 200)
                ->header('Content-Type', $document->file_mime)
                ->header('Content-Length', $document->file_size)
                ->header('Content-Disposition', 'attachment; filename="' . $document->file_name . '"');
        }
        return false;
    }

    /**
     * Get all documents in the trash
     * @return object Documents object
     */

    public function getTrashFiles()
    {
        $documents = $this->onlyTrashed()->get();
        activity_log(user_data()->data->id, 'get trash documents', null, 'Document', 'Documents');
        return $documents;
    }

    /*
    |--------------------------------------------------------------------------
    | Folder functions
    |--------------------------------------------------------------------------
    */

    /**
     * Get all documents in a folder or root folder
     * @param uuid|null $folder_id UUID of the folder or null for root folder
     * @return object Documents object
     */
    public function getDocuments($folder_id)
    {
        if ($folder_id == null) {
            $documents = $this->where('category_id', null)->get();
        } else {
            $documents = $this->where('category_id', $folder_id)->get();
        }
        activity_log(user_data()->data->id, 'get documents', null, 'Document', 'Documents');
        return $documents;
    }

    /**
     * Get all folders
     * @return object Folders object
     */
    public function getFolders()
    {
        $folders = new Category();
        $folders = $folders->getCategoriesByModule('archive');

        $folders[] = [
            'id' => null,
            'label' => '/',
            'parent_category' => null,
        ];
        activity_log(user_data()->data->id, 'get folders', null, 'Document', 'Folders');
        return $folders;
    }

    /**
     * Get a folder
     * @param uuid $folder_id UUID of the folder
     * @return object Folder object
     */
    public function getFolder($folder_id)
    {
        $folder = Category::where('id', $folder_id)->first();
        activity_log(user_data()->data->id, 'get folder', $folder_id, 'Document', 'Folder');
        return $folder;
    }

    /**
     * Create a new folder
     * @param uuid|null $parent_category UUID of the parent folder or null for root folder
     * @param string $name Name of the folder
     * @return bool True if folder was created, false if not
     */
    public function createFolder($parent_category, $name)
    {
        $category = new Category();
        $category = $category->createCategory($name, 'archive', 'folder', null, $parent_category);
        if ($category) {
            return true;
        }
        return false;
    }

    /**
     * Update a folder
     * @param uuid $folder_id UUID of the folder
     * @param uuid|null $parent_category UUID of the parent folder or null for root folder
     * @param string $name Name of the folder
     * @return bool True if folder was updated, false if not
     */
    public function updateFolder($folder_id, $data)
    {
        $category = new Category();
        $data = [
            'name' => $data['label'],
        ];
        $category = $category->updateCategory($folder_id, $data);
        if ($category) {
            return true;
        }
        return false;
    }

    /**
     * Delete a folder
     * @param uuid $folder_id UUID of the folder
     * @return bool True if folder was deleted, false if not
     */
    public function deleteFolder($folder_id)
    {
        $category = new Category();
        $category = $category->deleteCategory($folder_id);
        if ($category) {
            return true;
        }
        return false;
    }
}
