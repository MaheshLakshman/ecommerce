<?php

namespace App\Models;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'status'
    ];

    public function variant()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }

    public function getImageAttribute($value)
    {
        return $value ? asset(Storage::url($value)) : url(config('ecommerce.file_image'));
    }

}
