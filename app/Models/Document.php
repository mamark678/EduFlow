<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'module_id',
        'title',
        'description',
        'file_path',
        'original_filename',
        'file_type',
        'file_size',
        'order',
        'is_published',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Get the module that owns the document.
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Scope a query to only include published documents.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to order documents by their order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get the formatted file size.
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get the file icon based on file type.
     */
    public function getFileIconAttribute()
    {
        $icons = [
            'pdf' => '📄',
            'doc' => '📝',
            'docx' => '📝',
            'ppt' => '📊',
            'pptx' => '📊',
            'xls' => '📈',
            'xlsx' => '📈',
            'txt' => '📄',
            'zip' => '📦',
            'rar' => '📦',
        ];

        return $icons[$this->file_type] ?? '📎';
    }

    /**
     * Get the download URL for the file.
     */
    public function getDownloadUrlAttribute()
    {
        return route('documents.download', $this->id);
    }
}
