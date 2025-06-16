<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'original_filename',
        'file_path',
        'file_type',
        'file_size',
        'category_id',
        'content_preview' // ← مهم جداً
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
