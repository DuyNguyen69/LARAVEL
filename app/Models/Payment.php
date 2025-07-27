<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'amount',
        'status',
        'paid_at',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
    
}

