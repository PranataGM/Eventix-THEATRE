<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        
        $images = [
            'https://images.unsplash.com/photo-1540552745300-3db392be3446?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=1000&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=1000&auto=format&fit=crop',
        ];

        foreach ($categories as $category) {
            for ($i = 1; $i <= 10; $i++) {
                $eventName = $category->name . ' Event ' . $i . ' ' . Str::random(3);
                
                $event = Event::create([
                    'name' => $eventName,
                    'description' => 'Ini adalah deskripsi untuk ' . $eventName . '. Acara ini sangat spektakuler dan wajib ditonton. Jangan sampai kehabisan tiket!',
                    'location' => 'Gedung Kesenian Jakarta',
                    'event_date' => Carbon::now()->addDays(rand(1, 60)),
                    'capacity' => 100,
                    'category_id' => $category->id,
                    'user_id' => 1,
                ]);

                // Create Ticket Types for this event
                TicketType::create([
                    'event_id' => $event->id,
                    'name' => 'Reguler',
                    'price' => rand(50, 150) * 1000, // 50k - 150k
                    'quota' => 80,
                ]);

                TicketType::create([
                    'event_id' => $event->id,
                    'name' => 'VIP',
                    'price' => rand(250, 500) * 1000, // 250k - 500k
                    'quota' => 20,
                ]);
            }
        }
    }
}
