<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpleReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'category',
        'location',
        'date',
    ];

   /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'location' => 'json',
        'date' => 'datetime',
    ];
}
