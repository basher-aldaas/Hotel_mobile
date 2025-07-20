<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'image',
        'description',
        'price',
        'wifi',
        'room_type',
        'status',
        'bed_number',
        'valuation',
    ];

    public function bookings() : hasMany
    {
        return $this->hasMany(Booking::class);
    }

   public function offers() : hasMany
   {
       return $this->hasMany(Offer::class);
   }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}
