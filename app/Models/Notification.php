<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = [];

    public function markAsRead()
    {
        $this->read_at = now();
        $this->save();
    }
}

