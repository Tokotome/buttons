<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Button;

class ButtonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Button::create([
            'position' => 1, 'color' => '#FF0000', 'hyperlink' => 'https://youtube.com'
        ]);

        Button::create([
            'position' => 2, 'color' => '#00FF00', 'hyperlink' => ''
        ]);

        Button::create([
            'position' => 3, 'color' => '#0000FF', 'hyperlink' => 'https://facebook.com'
        ]);

        Button::create([
            'position' => 4, 'color' => '#FFFF00', 'hyperlink' => ''
        ]);

        Button::create([
            'position' => 5, 'color' => '#FF00FF', 'hyperlink' => 'https://google.com'
        ]);

        Button::create([
            'position' => 6, 'color' => '#00FFFF', 'hyperlink' => ''
        ]);

        Button::create([
            'position' => 7, 'color' => '#000000', 'hyperlink' => 'https://instagram.com'
        ]);

        Button::create([
            'position' => 8, 'color' => '#FFFFFF', 'hyperlink' => ''
        ]);

        Button::create([
            'position' => 9, 'color' => '#C0C0C0', 'hyperlink' => ''
        ]);
    }
}