<?php

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

        $profession = DB::table('professions')
            ->select('id')
            ->where('title', '=', 'Desarrollador back-end')
            ->value('id');

        DB::table('users')->insert([
            'name' => "Francisco Jesús",
            'email' => "francisco.adan@escuelaestech.es",
            'password' => bcrypt('laravel'),
            'profession_id' => $profession
        ]);
    }
}
