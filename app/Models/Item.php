<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['date'];
    const UPDATED_AT = null;

    protected $fillable = [
        'title', 'type', 'category_id', 'description', 'image_paths',
        'location', 'fullname', 'email', 'phone_number', 'social_media', 'date'
    ];

    protected $casts = [
        'image_paths' => 'array',
        'location' => 'array',
        'social_media' => 'array',
        'date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function report()
    {
        return $this->hasOne(Report::class);
    }
}
