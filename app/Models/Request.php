<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Report;

class Request extends Model
{
    protected $fillable = ['detailed_report_id', 'user_id', 'type', 'status'];

    public function detailedReport()
    {
        return $this->belongsTo(Report::class, 'detailed_report_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'user_id', 'user_id');
    }
}


