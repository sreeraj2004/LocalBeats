<?php

// app/Models/Musician.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Musician extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'band_name', 'genre'];

    // A musician belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
