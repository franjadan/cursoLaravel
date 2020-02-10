<?php

use App\User;
use App\Profession;
use App\Skill;
use App\UserProfile;
use App\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{

    protected $professions;
    protected $skills;
    protected $teams;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->fetchRelations();

        $this->createAdmin();

        $this->createRandomUsers();

    }

    protected function fetchRelations()
    {
        $this->professions = Profession::all();
        $this->skills = Skill::all();
        $this->teams = Team::all();
    }

    protected function createAdmin()
    {
        $admin = factory(User::class)->create([
            'team_id' => $this->teams->firstWhere('name', 'Estech'),
            'name' => "Francisco Jesús",
            'email' => "francisco.adan@escuelaestech.es",
            'password' => bcrypt('laravel'),
            'role' => 'admin',
            'created_at' => now()->addDay()
        ]);

        $randomSkills = $this->skills->random(rand(0, 7));

        $admin->skills()->attach($randomSkills);

        $admin->profile()->create([
            'bio' => 'Programador, profesor, editor, escritor, social media manger',
            'profession_id' => $this->professions->firstWhere('title', 'Desarrollador back-end')->id
        ]);
    }

    protected function createRandomUsers() {
        foreach(range(1, 999) as $i) {
            $user =  factory(User::class)->create([
                'team_id' => rand(0,2) ? $this->teams->random()->id : null
            ]);
       
            $randomSkills = $this->skills->random(rand(0, 7));

            $user->skills()->attach($randomSkills);

            factory(App\UserProfile::class)->create([
                'user_id' => $user->id,
                'profession_id' => rand(0,2) ? $this->professions->random()->id : null
            ]);
        }  
    }
}
