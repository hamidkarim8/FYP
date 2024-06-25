<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Report extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id', 'item_id', 'type'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'detailed_report_id', 'id');
    }

    public function checkRequests()
    {
        return $this->hasOne(Request::class, 'detailed_report_id', 'id')->latestOfMany();
    }
    public function getSimilarItems()
    {
        return Item::where('type', 'detailed')
            ->where('category_id', $this->item->category_id)
            ->where('title', 'LIKE', '%' . $this->title . '%')
            ->get();
    }
    public function pendingRequests()
    {
        return $this->hasMany(Request::class, 'detailed_report_id')->where('status', 'pending');
    }
    public function approvedRequests()
    {
        return $this->hasMany(Request::class, 'detailed_report_id')->where('status', 'approved');
    }
    public function declinedRequests()
    {
        return $this->hasMany(Request::class, 'detailed_report_id')->where('status', 'declined');
    }
}
