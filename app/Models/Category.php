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

    public static function getAllChildrenIds($parentId)
    {
        $ids = [$parentId];
        $children = self::where('category_id', $parentId)->pluck('id');
        
        foreach ($children as $childId) {
            $ids = array_merge($ids, self::getAllChildrenIds($childId));
        }
        
        return $ids;
    }
}
