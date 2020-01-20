<?php

use \App\Models\User;
use \App\Models\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //$profession = DB::select('SELECT id FROM professions WHERE title = ?', ['Desarrollador back-end']);

        $profession = Profession::where('title', '=', 'Desarrollador back-end')->value('id');

        User::create([
            'name' => "Francisco Jesús",
            'email' => "francisco.adan@escuelaestech.es",
            'password' => bcrypt('laravel'),
            'profession_id' => $profession
        ]);
    }
}
