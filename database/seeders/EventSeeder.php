<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Talk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::factory()->count(20)->create()->each(function ($event) {
            $rooms = ['Room A', 'Room B', 'Room C', 'Room D'];


            Talk::factory()->count(rand(6, 8))->create([
                'event_id' => $event->id,
                'room_location' => $rooms[array_rand($rooms, 1)]
            ]);

        });
    }
}
