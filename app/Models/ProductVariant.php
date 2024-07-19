<?php

namespace App\Models;

use App\Models\Product;
use App\Models\VariantOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'price',
        'quantity',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
 
    public function productOption()
    {
        return $this->belongsToMany(VariantOption::class, 'variant_option_products', 'product_variant_id', 'variant_option_id');
    }

}
