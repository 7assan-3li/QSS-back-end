<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderCategoryRequest extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'description',
        'document_path',
        'status',
        'rejection_reason',
        'admin_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
