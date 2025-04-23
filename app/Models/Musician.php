<?php

// app/Models/Musician.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Musician extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'band_name',
        'genre',
        'bio',
        'location',
        'profile_photo'
    ];

    // A musician belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function featured_music()
    {
        return $this->hasMany(FeaturedMusic::class);
    }

    public function upcoming_events()
    {
        return $this->hasMany(UpcomingEvents::class);
    }
}
