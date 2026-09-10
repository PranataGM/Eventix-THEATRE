<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $organizer = User::where('email', 'admin@admin.com')->first();
        
        if (!$organizer) {
            $organizer = User::factory()->create(['name' => 'Admin Dummy', 'email' => 'dummy@admin.com']);
        }

        $faker = \Faker\Factory::create('id_ID');

        $eventCategories = ['Konser Musik', 'Teater Drama', 'Seminar Teknologi', 'Workshop Seni', 'Festival Kuliner', 'Stand-up Comedy', 'Pameran Lukisan', 'Simfoni Orkestra'];

        for ($i = 1; $i <= 20; $i++) {
            $category = $eventCategories[array_rand($eventCategories)];
            $eventName = $category . ' Spesial ' . $faker->city;

            $event = Event::create([
                'user_id' => $organizer->id,
                'name' => $eventName,
                'description' => $faker->paragraphs(3, true),
                'event_date' => now()->addDays(rand(2, 60))->setTime(rand(10, 20), array_rand([0 => 0, 30 => 30])),
                'location' => $faker->company . ' Hall, ' . $faker->city,
                'capacity' => rand(200, 1000),
            ]);

            $ticketType1 = TicketType::create([
                'event_id' => $event->id,
                'name' => 'Reguler',
                'price' => rand(5, 15) * 10000,
                'quota' => rand(150, 400),
            ]);

            $ticketType2 = TicketType::create([
                'event_id' => $event->id,
                'name' => 'VIP',
                'price' => rand(25, 50) * 10000,
                'quota' => rand(50, 100),
            ]);

            // Buat beberapa tiket per event agar grafik dashboard terlihat penuh
            $ticketsCount = rand(3, 8);
            for ($j = 1; $j <= $ticketsCount; $j++) {
                $user = User::factory()->create();
                Registration::create([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                    'ticket_type_id' => $j % 2 == 0 ? $ticketType2->id : $ticketType1->id,
                    'ticket_code' => 'TIX-' . strtoupper(Str::random(8)),
                    'status' => 'confirmed',
                    'is_checked_in' => (rand(1, 10) > 7), // 30% peluang sudah check-in
                    'checked_in_at' => now()->subHours(rand(1, 12)),
                ]);
            }
        }
    }
}
