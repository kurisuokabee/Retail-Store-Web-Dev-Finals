<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'product_name',
        'description',
        'category_id',
        'supplier_id',
        'unit_price',
        'cost_price',
        'is_active',
    ];

    // Product.php
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id');
    }

    /**
     * Apply sorting from query parameter
     *
     * Accepts:
     *  - price_asc  (low -> high)
     *  - price_desc (high -> low)
     */
    public function scopeApplySort($query, $sort)
    {
        if (!$sort) {
            return $query;
        }
        switch ($sort) {
            case 'price_asc':
                return $query->orderBy('unit_price', 'asc');
            case 'price_desc':
                return $query->orderBy('unit_price', 'desc');
            default:
                return $query;
        }
    }

    /**
     * Search products by a term across product_name, description, and category name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $term)
    {
        $term = trim((string) $term);
        if ($term === '') {
            return $query;
        }

        $likeTerm = '%' . str_replace('%', '\\%', $term) . '%';

        return $query->where(function ($q) use ($likeTerm) {
            $q->where('product_name', 'like', $likeTerm)
                ->orWhere('description', 'like', $likeTerm)
                ->orWhereHas('category', function ($q2) use ($likeTerm) {
                    $q2->where('category_name', 'like', $likeTerm);
                });
        });
    }

    /**
     * Scope to only return in-stock products when $active is true.
     *
     * Usage: Product::inStock($request->boolean('in_stock'))
     */
    public function scopeInStock($query, $active = true)
    {
        if (!$active) {
            return $query;
        }

        // assumes 'inventory' relationship exists and has 'stock_quantity'
        return $query->whereHas('inventory', function ($iq) {
            $iq->where('stock_quantity', '>', 0);
        });
    }
}
