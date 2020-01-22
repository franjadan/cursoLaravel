<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\DB;

class UsersModuleTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    function it_shows_the_user_list_page()
    {

        factory(User::class)->create([
            'name' => 'Joel'
        ]);

        factory(User::class)->create([
            'name' => 'Ellie'
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Joel')
            ->assertSee('Ellie');
    }

    /** @test */
    function it_shows_a_default_message_if_the_users_list_is_empty()
    {

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('No hay usuarios registrados');
    }
    
    /** @test */
    function it_loads_the_users_detail_page()
    {

        $user = factory(User::class)->create([
            'name' => 'Francisco Jesús'
        ]);

        $this->get("/usuarios/" . $user->id)
            ->assertStatus(200)
            ->assertSee('Francisco Jesús');
    }

    /** @test */
    function it_displays_a_error_404_if_the_user_is_not_found()
    {
        $this->get('usuarios/999')
        ->assertStatus(404)
        ->assertSee('Página no encontrada');
    }

    /** @test */
    function it_loads_the_new_users_page()
    {
        $this->get('usuarios/nuevo')
        ->assertStatus(200)
        ->assertSee('Crear usuario');
    }

    /** @test */
    function it_loads_the_user_edit_page()
    {
        $this->get('usuarios/5/edit')
            ->assertStatus(200)
            ->assertSee('Editando al usuario 5');
    }

    /** @test */
    function it_creates_a_new_user()
    {
        $this->post('/usuarios/crear', [
            'name' => 'Usuario',
            'email' => 'usuario@nuevo.com',
            'password' => '123456'
        ])->assertRedirect(route('users.index'));

        $this->assertCredentials([
            'name' => 'Usuario',
            'email' => 'usuario@nuevo.com',
            'password' => '123456'
        ]);
    }

    /** @test */
    function the_name_is_required()
    {
        $this->from('usuarios/nuevo')->post('/usuarios/crear', [
            'name' => '',
            'email' => 'usuario@nuevo.com',
            'password' => '123456'
        ])->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);

        $this->assertEquals(0, User::count());

        /*
        $this->assertDatabaseMissing('users', [
            'email' => 'usuario@nuevo.com'
        ]);
        */
    }
}
