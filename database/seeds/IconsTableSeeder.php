<?php

use Illuminate\Database\Seeder;

class IconsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Entities\Icon::truncate();
        $file = file_get_contents(storage_path('app').'/public/icons.json');
        $icons = json_decode($file,true);
        foreach ($icons as $icon){
            \App\Entities\Icon::create($icon);
        }
    }
}
