<?php

namespace App\Models;

use App\Models\VariantOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Variant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status'
    ];

    public function options()
    {
        return $this->hasMany(VariantOption::class, 'variant_id', 'id');
    }

}
