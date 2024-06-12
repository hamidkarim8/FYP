<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailedReport extends Model
{
    use HasFactory;

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
        'image_paths' => 'array',
        'location' => 'array',
        'social_media' => 'array',
        'reported_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

