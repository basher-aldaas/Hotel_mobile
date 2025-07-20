<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'room_id',
        'start_date',
        'end_date',
        'payment_status',
        'guests_count',
        'status',
        'final_price',
    ];

    public function user () :belongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function room() : belongsTo
    {
        return $this->belongsTo(Room::class);
    }

}
