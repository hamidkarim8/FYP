<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Import the User model
use App\Models\LostItem; // Import the LostItem model
use App\Models\FoundItem; // Import the FoundItem model
use App\Models\Feedback; // Import the Feedback model
use App\Models\Report; // Import the Report model
use App\Models\Notification; // Import the Notification model

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create()->each(function ($user) {
            $user->lostItems()->saveMany(LostItem::factory(3)->make());
            $user->foundItems()->saveMany(FoundItem::factory(3)->make());
            $user->feedbacks()->saveMany(Feedback::factory(3)->make());
            $user->reports()->saveMany(Report::factory(3)->make());
            $user->notifications()->saveMany(Notification::factory(3)->make());
        });    }
}
 