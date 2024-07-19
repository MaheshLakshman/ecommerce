<?php

namespace App\Models;

use App\Models\Variant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VariantOption extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'variant_id',
        'name',
        'status'
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id', 'id');
    }
}
