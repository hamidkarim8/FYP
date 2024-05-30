<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'itemName', 'description', 'location', 'dateLost', 'isResolved', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
