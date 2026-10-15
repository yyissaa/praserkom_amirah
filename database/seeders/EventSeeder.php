<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table ('events')->insert([
            [
                'title' => 'BTS World Tour 2026',
                'category' => 'Musik',
                'ticket_price' => '1000000',
                'description' => 'Konser musik dari boygroup Korea di GBK',
                'image' => 'null',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'AlloBank 2026',
                'category' => 'Festival',
                'ticket_price' => '700000',
                'description' => 'Festival musik dari AlloBank mengundang beberapa artis serta mengundang salah satu boyband dari Korea',
                'image' => 'null',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Seminar Telkom Indonesia 2027',
                'category' => 'Seminar',
                'ticket_price' => '100000',
                'description' => 'Seminar Offline dari Telkom Indonesia yang dilaksanakan di Universitas Indonesia',
                'image' => 'null',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'BOYNEXTDOOR World Tour 2026',
                'category' => 'Musik',
                'ticket_price' => '1500000',
                'description' => 'Konser musik dari boygroup Korea di Indonesia Arena',
                'image' => 'null',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Festival Kuliner 2026',
                'category' => 'Festival',
                'ticket_price' => '50000',
                'description' => 'Festival Kuliner Di ICE BSD mengundang beberapa tenant makanan viral',
                'image' => 'null',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
