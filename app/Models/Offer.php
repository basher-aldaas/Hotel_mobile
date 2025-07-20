<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
        'title',
        'description',
        'discount',
        'start_date',
        'end_date',
    ];

    public function room() : belongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
