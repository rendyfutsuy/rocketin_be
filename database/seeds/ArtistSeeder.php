<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Video\Models\Artist;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeder = new Artist();
        $seeder->unguard();
        $seeder->unsetEventDispatcher();
        
        $items = [
            [
                'name' => 'Rendy Anggara',
            ],

            [
                'name' => 'Angga',
            ],

            [
                'name' => 'Bukan Rendy',
            ],
        ];

        foreach ($items as $item) {
            $seeder->create($item);
        }
    }
}
