<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class DetailedReport extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'title',
        'type',
        'category_id',
        'description',
        'image_paths',
        'location',
        'fullname',
        'email',
        'phone_number',
        'social_media',
        'reported_at',
    ];

    protected $casts = [
        'id' => 'string',
        'image_paths' => 'array',
        'location' => 'array',
        'social_media' => 'array',
        'reported_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // Attach a creating event listener to generate UUID
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    // Accessor for image_paths to automatically decode JSON
    // public function getImagePathsAttribute($value)
    // {
    //     return is_string($value) ? json_decode($value, true) : $value;
    // }

    // // Accessor for social_media to automatically decode JSON
    // public function getSocialMediaAttribute($value)
    // {
    //     return is_string($value) ? json_decode($value, true) : $value;
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

