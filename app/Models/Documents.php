<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\URL;

class Documents extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'documents';

    protected $fillable = [
        'document_creator_id',
        'document_category_id',
        'number',
        'name',
        'date',
        'due_date',
        'access',
        'status',
        'type',
        'version',
        'content',
        'archived',
        'archive_name',
        'archive_path',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
    ];

    public function generateTags(): array
    {
        return ['Documents'];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'document_creator_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'document_category_id');
    }

    /**
     * Get all documents
     *
     * @return array $documents
     */
    public function getDocuments()
    {
        $documents = $this->with('creator')->with('category')->get();

        return $documents;
    }

    /**
     * Get document by id
     *
     * @param string $id
     * @return array $document
     */
    public function getDocument($id)
    {
        $document = $this->with('creator')->with('category')->where('id', $id)->first();

        $document->preview = URL::signedRoute('document.pdf', ['id' => $document->id, 'type' => 'preview', 'lang' => app()->getLocale()]);
        $document->download = URL::signedRoute('document.pdf', ['id' => $document->id, 'type' => 'download', 'lang' => app()->getLocale()]);

        return $document;
    }

    /**
     * Get next document number based on settings
     *
     * @return string $number
     */
    public function getDocumentNumber()
    {
        $number = generate_next_number(settings('document_number_format'), 'documents');
        return $number;
    }

    /**
     * Create document
     *
     * @param array $data
     * @return array $document
     */
    public function createDocument($data)
    {
        $document = $this->create($data);
        incrementLastItemNumber('documents');
        if ($document) {
            return true;
        }
        return false;
    }

    /**
     * Update document
     *
     * @param array $data
     * @param string $id
     * @return array $document
     */

    public function updateDocument($data, $id)
    {
        $document = $this->where('id', $id)->first();

        if (isset($data['content'])) {
            $data['version'] = $document->version + 1;
        }
        $document = $document->update($data);

        if ($document) {
            return true;
        }
        return false;
    }

    /**
     * Delete document
     *
     * @param string $id
     * @return boolean
     */
    public function deleteDocument($id)
    {
        $document = $this->where('id', $id)->first();
        return $document->delete();
    }

    /**
     * Generate PDF
     *
     * @param string $id
     * @return blob $pdf
     */

    public function getDocumentPDF($id, $type = 'stream')
    {
        $document = $this->where('id', $id)->first();
        $pdf = Pdf::loadView('pdfs.document_internal', compact('document'));

        if ($type == 'attach') {
            return $pdf->output();
        }

        if ($type == 'stream') {
            return $pdf->stream($document->name . '.pdf');
        } else {
            return $pdf->download($document->name . '.pdf');
        }
    }
}
