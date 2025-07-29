<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Rental extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'status',
        'pickup_date',
        'pickup_time',
        'dropoff_date',
        'dropoff_time',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_id_number',
        'delivery_option',
        'delivery_address',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'car_id')->withDefault([
            'name' => 'No vehicle'
        ]);
    }
    // app/Models/Rental.php

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function calculateTotal(): float
{
    $pickup = \Carbon\Carbon::parse($this->pickup_date . ' ' . $this->pickup_time);
    $dropoff = \Carbon\Carbon::parse($this->dropoff_date . ' ' . $this->dropoff_time);

    $durationDays = ceil($pickup->floatDiffInHours($dropoff) / 24);

    $pricePerDay = $this->vehicle->price_per_day;
    $total_price = $pricePerDay * $durationDays;

    // Giảm giá nếu thuê dài ngày
    if ($durationDays >= 7) {
        $total_price *= 0.9; // giảm 10%
    } elseif ($durationDays >= 3) {
        $total_price *= 0.95; // giảm 5%
    }

    // Phụ phí giao xe nếu có
    if (!empty($this->delivery_address)) {
        $total_price += 100_000;
    }

    return $total_price;
}
public function getStatusColorAttribute()
{
    return match ($this->status) {
        'pending' => 'warning',
        'confirmed' => 'success',
        'completed' => 'primary',
        'canceled' => 'danger',
        default => 'secondary',
    };
}

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELED = 'canceled';
}
