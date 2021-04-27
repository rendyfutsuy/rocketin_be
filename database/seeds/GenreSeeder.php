<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Video\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeder = new Genre();
        $seeder->unguard();
        $seeder->unsetEventDispatcher();
        
        $items = [
            [
                'name' => 'Action',
            ],

            [
                'name' => 'Comedy',
            ],

            [
                'name' => 'Horror',
            ],
        ];

        foreach ($items as $item) {
            $seeder->create($item);
        }
    }
}
