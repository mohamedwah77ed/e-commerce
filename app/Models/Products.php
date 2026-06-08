<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'cat_id',
        'child_cat_id',
        'price',
        'brand_id',
        'discount',
        'status',
        'stock',
        'is_featured',
        'condition',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'price'       => 'decimal:2',
        'discount'    => 'decimal:2',
    ];

    /* ── Scopes ─────────────────────────── */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }

    /* ── Relationships ──────────────────── */

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function cat_info()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function sub_cat_info()
    {
        return $this->belongsTo(Category::class, 'child_cat_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }

    public function brand_info()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }

    /* ── Accessors ──────────────────────── */

    public function getFinalPriceAttribute()
    {
        if ($this->discount && $this->discount > 0) {
            return round($this->price - ($this->price * $this->discount / 100), 2);
        }
        return $this->price;
    }

    public function getFirstImageAttribute()
    {
        return $this->images->first()?->image;
    }

    /* ── Static Methods ─────────────────── */

    public static function getAllProduct()
    {
        return self::with(['cat_info', 'sub_cat_info', 'images'])
                   ->orderBy('id', 'desc')
                   ->paginate(12);
    }

    public static function getAllProductsActive()
    {
        return self::with(['cat_info', 'sub_cat_info', 'brand', 'images'])
                   ->active()
                   ->inStock()
                   ->latest()
                   ->get();
    }

    public static function getByBrand(int $brandId)
    {
        return self::with(['cat_info', 'sub_cat_info', 'brand', 'images'])
                   ->where('brand_id', $brandId)
                   ->active()
                   ->inStock()
                   ->latest()
                   ->paginate(12);
    }

    public static function search(string $keyword)
    {
        return self::with(['cat_info', 'sub_cat_info', 'images'])
                   ->active()
                   ->inStock()
                   ->where(function ($query) use ($keyword) {
                       $query->where('title', 'LIKE', "%{$keyword}%")
                             ->orWhere('summary', 'LIKE', "%{$keyword}%");
                   })
                   ->latest()
                   ->paginate(12);
    }
}
