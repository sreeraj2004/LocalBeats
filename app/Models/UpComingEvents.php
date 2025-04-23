<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpComingEvents extends Model
{
    protected $table = 'upcoming_events';
    protected $fillable = [
        'image',
        'name',
        'date',
        'location',
        'time',
        'price',
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'float',
    ];

    public function musician()
    {
        return $this->belongsTo(Musician::class);
    }
}
