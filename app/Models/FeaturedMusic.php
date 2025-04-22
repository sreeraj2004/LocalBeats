<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class FeaturedMusic extends Model
{
    use HasFactory;
    
    protected $table = 'featured_music';
    protected $fillable = [
        'image',
        'artist_name',
        'genre',
        'ratings',
        'song_path',
        'musician_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Add relationship to Musician model
    public function musician()
    {
        return $this->belongsTo(Musician::class);
    }
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            Log::info('Creating new FeaturedMusic record with data:', $model->toArray());
        });
        
        static::created(function ($model) {
            Log::info('FeaturedMusic record created with ID: ' . $model->id);
        });
    }
}
