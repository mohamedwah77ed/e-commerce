<?php

namespace App\Models;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'status'];

    /**
     * Get all brands (static helper).
     */
    public static function getAllBrands()
    {
        return self::latest('id')->get();
    }

    /**
     * Get only active brands (static helper).
     */
    public static function getActiveBrands()
    {
        return self::where('status', 'active')
                   ->latest('id')
                   ->get();
    }

    /**
     * Relationship: Brand has many Products.
     */
    public function products()
    {
        return $this->hasMany(Products::class, 'brand_id', 'id')
                    ->where('status', 'active');
    }

    /**
     * Scope: Active brands only.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Latest first.
     */
    public function scopeLatestFirst($query)
    {
        return $query->latest('id');
    }
    public static function getBySlug(string $slug): ?self
{
    return self::where('slug', $slug)
               ->where('status', 'active')
               ->firstOrFail();
}

}
