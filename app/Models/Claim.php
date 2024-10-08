<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'request_id',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function request()
    {
        return $this->belongsTo(Request::class);
    }
}

