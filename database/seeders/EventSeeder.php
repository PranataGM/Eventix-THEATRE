<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $organizer = User::where('email', 'organizer@event.com')->first();
        $catTeater = \App\Models\Category::where('name', 'Teater & Drama')->first();
        $catKonser = \App\Models\Category::where('name', 'Konser Musik')->first();
        $catFestival = \App\Models\Category::where('name', 'Festival')->first();

        // Event 1
        $event1 = Event::create([
            'user_id' => $organizer->id,
            'category_id' => $catTeater->id ?? null,
            'name' => 'The Phantom of the Opera',
            'description' => 'Saksikan drama musikal legendaris The Phantom of the Opera secara langsung. Pertunjukan spektakuler yang tidak boleh Anda lewatkan.',
            'event_date' => Carbon::now()->addDays(5)->setTime(19, 0),
            'location' => 'Gedung Kesenian Jakarta',
            'capacity' => 500,
        ]);

        TicketType::create([
            'event_id' => $event1->id,
            'name' => 'VIP',
            'price' => 1500000,
            'quota' => 100,
        ]);

        TicketType::create([
            'event_id' => $event1->id,
            'name' => 'Regular',
            'price' => 500000,
            'quota' => 400,
        ]);

        // Event 2
        $event2 = Event::create([
            'user_id' => $organizer->id,
            'category_id' => $catKonser->id ?? null,
            'name' => 'Konser Orkestra Simfoni',
            'description' => 'Malam yang dipenuhi dengan melodi indah dari komposer terkenal, dibawakan oleh orkestra simfoni terbaik.',
            'event_date' => Carbon::now()->addDays(10)->setTime(20, 0),
            'location' => 'Aula Simfonia Jakarta',
            'capacity' => 300,
        ]);

        TicketType::create([
            'event_id' => $event2->id,
            'name' => 'Balcony',
            'price' => 750000,
            'quota' => 150,
        ]);

        TicketType::create([
            'event_id' => $event2->id,
            'name' => 'Stalls',
            'price' => 1000000,
            'quota' => 150,
        ]);

        // Event 3
        $event3 = Event::create([
            'user_id' => $organizer->id,
            'category_id' => $catFestival->id ?? null,
            'name' => 'Festival Teater Mahasiswa',
            'description' => 'Berbagai pertunjukan teater indie dan kreatif dari mahasiswa seluruh Indonesia.',
            'event_date' => Carbon::now()->addDays(20)->setTime(16, 0),
            'location' => 'Teater Kecil TIM',
            'capacity' => 200,
        ]);

        TicketType::create([
            'event_id' => $event3->id,
            'name' => 'General Admission',
            'price' => 50000,
            'quota' => 200,
        ]);
    }
}
