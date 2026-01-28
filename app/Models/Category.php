<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'category_id','image_path'];


    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function children()
    {
        return $this->hasMany( Category::class, 'category_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function services()
    {
        return $this->hasMany( Service::class, 'category_id');
    }
}
