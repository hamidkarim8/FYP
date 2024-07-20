<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_id',
        'deleted_type',
        'remarks',
    ];
}
