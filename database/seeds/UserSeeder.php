<?php

use App\User;
use App\Profession;
use App\UserProfile;
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

        $professionId = Profession::where('title', '=', 'Desarrollador back-end')->value('id');

        $user = factory(User::class)->create([
            'name' => "Francisco Jesús",
            'email' => "francisco.adan@escuelaestech.es",
            'password' => bcrypt('laravel'),
            'role' => 'admin'
        ]);

        $user->profile()->create([
            'bio' => 'Programador, profesor, editor, escritor, social media manger',
            'profession_id' => $professionId
        ]);

        factory(User::class, 29)->create()->each(function($user){
            $user->profile()->create(
                factory(App\UserProfile::class)->raw()
            );
        });
    }
}
