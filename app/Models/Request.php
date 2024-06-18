<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = ['detailed_report_id', 'user_id', 'type', 'status'];

    public function detailedReport()
    {
        return $this->belongsTo(DetailedReport::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


