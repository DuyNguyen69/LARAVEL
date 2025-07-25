<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'cars';

    public $timestamps = true;
    public $guarded = [];

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price_per_day, 0, ',', '.') . '₫';
    }
    public function ProductCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
}
