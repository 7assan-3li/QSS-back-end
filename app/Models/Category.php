<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'category_id','image_path'];

    protected static function booted()
    {
        static::saved(fn () => static::clearHierarchyCache());
        static::deleted(fn () => static::clearHierarchyCache());
    }


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

    /**
     * Check if this category or any of its children have services.
     */
    public function hasServicesRecursively(): bool
    {
        if ($this->services()->exists()) {
            return true;
        }

        foreach ($this->children as $child) {
            if ($child->hasServicesRecursively()) {
                return true;
            }
        }

        return false;
    }

    public static function getAllChildrenIds($parentId)
    {
        return \Illuminate\Support\Facades\Cache::remember("category_children_ids_{$parentId}", now()->addDay(), function () use ($parentId) {
            $ids = [$parentId];
            $children = self::where('category_id', $parentId)->pluck('id');
            
            foreach ($children as $childId) {
                $ids = array_merge($ids, self::getAllChildrenIds($childId));
            }
            
            return $ids;
        });
    }

    public static function clearHierarchyCache()
    {
        // This is a simple way, but in production with Redis you'd use tags.
        // For now, we rely on the 24h expiry or manual clear if needed.
        // Or better, we can clear the whole cache if categories change.
        \Illuminate\Support\Facades\Cache::flush(); 
    }
}
