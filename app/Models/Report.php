<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class Report extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id', 'item_id', 'type', 'isResolved'
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
        // Get the latest report's item
        $latestItem = $this->item;
    
        // Extract the desc value from the latest item's location
        $desc = $latestItem->location['desc'];
    
        // Log the desc value
        Log::info('Latest item location desc: ' . $desc);
    
        // Prepare the regex pattern to match the desc
        $descWords = array_filter(explode(' ', $desc)); // Split the desc into words
        $descPattern = implode('|', array_map('preg_quote', $descWords)); // Create a regex pattern from the words
        $descPatternLower = strtolower($descPattern); // Convert the pattern to lowercase
    
        // Log the regex pattern
        Log::info('Regex pattern for location desc: ' . $descPatternLower);
    
        // Find reports with similar items
        $similarReports = Report::where(function ($query) use ($latestItem, $descPatternLower) {
                $query->whereHas('item', function ($itemQuery) use ($latestItem, $descPatternLower) {
                    $itemQuery->where('category_id', $latestItem->category_id)
                              ->orWhere('title', 'like', '%' . $latestItem->title . '%')
                              ->orWhereRaw('LOWER(JSON_EXTRACT(location, "$.desc")) REGEXP ?', [$descPatternLower]);
                });
            })
            ->where('type', 'detailed')
            ->get();
    
        // Collect the items from similar reports
        $similarItems = $similarReports->map(function ($report) {
            return $report->item;
        });
    
        // Log similar items count
        Log::info('Similar items count: ' . $similarItems->count());
    
        return $similarItems;
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
    public function claim()
    {
        return $this->hasOne(Claim::class);
    }
}
