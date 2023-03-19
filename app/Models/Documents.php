<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use OwenIt\Auditing\Contracts\Auditable;

class Documents extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'documents';

    protected $fillable = [
        'created_by',
        'name',
        'description',
        'file_name',
        'file_type',
        'file_size',
        'file_hash_sha256',
        'file_hash_md5',
        'file_path',
        'version',
    ];
    protected $dates = ['deleted_at'];

    public function generateTags(): array
    {
        return ['Document'];
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Create a new document
     *
     * @param Request $request
     * @return Document
     */
    public function createDocument($request)
    {
        try {
            DB::beginTransaction();
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $request->input('path'); // Path after storage/app/documents folder
                $fileName = $file->getClientOriginalName();

                if (Storage::exists('documents/' . $path . '/' . $fileName)) {
                    return false;
                }

                $file_path = $path . '/' . $fileName;
                if ($path == '' || $path == '/') {
                    $file_path = '/' . $fileName;
                }

                Documents::create([
                    'created_by' => user_data()->data->id,
                    'name' => $fileName,
                    'file_name' => $fileName,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                    'file_hash_sha256' => hash_file('sha256', $file),
                    'file_hash_md5' => hash_file('md5', $file),
                    'file_path' => $file_path,
                ]);
                $fileStore = $file->storeAs('documents' . $path, $fileName);
                if (!$fileStore) {
                    DB::rollBack();
                    return false;
                }
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function updateDocument($data)
    {
    }

    public function deleteDocument($path)
    {
        try {
            DB::beginTransaction();
            $document = Documents::where('file_path', $path)->first();
            if ($document) {
                $document->delete();
                if (Storage::exists('documents/' . $path)) {
                    Storage::delete('documents/' . $path);
                    DB::commit();
                    return true;
                }
                return false;
            }
            return false;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getDocument($path)
    {
        try {
            $file = Documents::where('file_path', $path)->first();
            if ($file) {
                if (Storage::exists('documents' . $file->file_path)) {
                    $file->preview_url = URL::signedRoute('documents.preview', ['path' => $file->file_path]);
                    $file->download_url = URL::signedRoute('documents.download', ['path' => $file->file_path]);
                    activity_log(user_data()->data->id, 'get document', $file->id, 'App\Models\Documents', 'getDocument');
                    return $file;
                }
                return false;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function previewDocument($path)
    {
        if (Storage::exists('documents' . $path)) {
            $file = Storage::get('documents' . $path);
            $file_name = explode('/', $path);
            $file_name = end($file_name);
            $file_type = Storage::mimeType('documents/' . $path);

            // TODO: Add log for user id and file id
            return response($file, 200)
                ->header('Content-Type', $file_type)
                ->header('Content-Disposition', 'inline; filename="' . $file_name . '"');
        }
        return false;
    }

    public function downloadDocument($path)
    {
        if (Storage::exists('documents' . $path)) {
            $file = Storage::get('documents' . $path);
            $file_name = explode('/', $path);
            $file_name = end($file_name);
            $file_type = Storage::mimeType('documents/' . $path);

            // TODO: Add log for user id and file id
            return response($file, 200)
                ->header('Content-Type', $file_type)
                ->header('Content-Disposition', 'attachment; filename="' . $file_name . '"');
        }
        return false;
    }

    // Folder operations

    /**
     * Get all documents from a path
     *
     * @param string $path Path after storage/app/documents folder
     * @return void Array of documents
     */
    public function getDocuments($path)
    {
        if (Storage::exists('documents' . $path)) {
            $files = Storage::files('documents' . $path);
            $folders = Storage::directories('documents' . $path);

            $files_array = [];
            $folders_array = [];

            foreach ($files as $file) {
                $file_name = explode('/', $file);
                $file_name = end($file_name);

                $files_array[] = [
                    'name' => $file_name,
                    'size' => Storage::size($file),
                    'type' => Storage::mimeType($file),
                    'extension' => File::extension($file),
                    'file' => true,
                    'hash_sha256' => hash_file('sha256', Storage::path($file)),
                    'hash_md5' => hash_file('md5', Storage::path($file)),
                    'path' => explode('documents', $file)[1],
                    'created_at' => Storage::lastModified($file),
                ];
            }

            foreach ($folders as $folder) {
                $folder_name = explode('/', $folder);
                $folder_name = end($folder_name);
                $folder_created_at = Storage::lastModified($folder);

                $folders_array[] = [
                    'name' => $folder_name,
                    'size' => 0,
                    'extension' => 'folder',
                    'type' => 'folder',
                    'file' => false,
                    'path' => explode('documents', $folder)[1],
                    'created_at' => $folder_created_at,
                ];
            }

            $documents = array_merge($folders_array, $files_array);

            // Folders first
            $documents = collect($documents)
                ->sortBy('file')
                ->toArray();

            activity_log(user_data()->data->id, 'get documents', $path, 'App\Models\Documents', 'getDocuments');

            return $documents;
        }
        return false;
    }

    public function getFolders($path)
    {
        if (Storage::exists('documents/' . $path)) {
            $folders = Storage::directories('documents' . $path);

            $folders_array = [];

            foreach ($folders as $folder) {
                $folder_name = explode('/', $folder);
                $folder_name = end($folder_name);

                $folders_array[] = [
                    'name' => $folder_name,
                    'extension' => 'folder',
                    'type' => 'folder',
                    'path' => explode('documents', $folder)[1],
                ];
            }

            activity_log(user_data()->data->id, 'get folders', $path, 'App\Models\Documents', 'getFolders');

            return $folders_array;
        }
    }

    public function createFolder($path, $folder_name)
    {
        if (Storage::exists('documents/' . $path)) {
            if (Storage::makeDirectory('documents/' . $path . '/' . $folder_name)) {
                activity_log(user_data()->data->id, 'create folder', $path . '/' . $folder_name, 'App\Models\Documents', 'createFolder');
                return true;
            }
        }
        return false;
    }

    public function deleteFolder($path)
    {
        if (Storage::exists('documents/' . $path)) {
            if (Storage::deleteDirectory('documents/' . $path)) {
                activity_log(user_data()->data->id, 'delete folder', $path, 'App\Models\Documents', 'deleteFolder');
                return true;
            }
        }
        return false;
    }
}
