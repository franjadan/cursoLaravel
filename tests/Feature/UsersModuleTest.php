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

        $user = factory(User::class)->create();
        
        $this->get("usuarios/{$user->id}/editar")
            ->assertStatus(200)
            ->assertSee('Editar usuario')
            ->assertViewHas('user', function($viewUser) use ($user) {
                return $viewUser->id == $user->id;
            });
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
    function it_updates_a_new_user()
    {
        $user = factory(User::class)->create();

        $this->put("/usuarios/{$user->id}", [
            'name' => 'Usuario',
            'email' => 'usuario@nuevo.com',
            'password' => '123456'
        ])->assertRedirect("usuarios/{$user->id}");

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

     /** @test */
     function the_email_is_required()
     {
         $this->from('usuarios/nuevo')->post('/usuarios/crear', [
             'name' => 'Usuario',
             'email' => '',
             'password' => '123456'
         ])->assertRedirect('usuarios/nuevo')
             ->assertSessionHasErrors(['email']);
 
         $this->assertEquals(0, User::count());
     }

      /** @test */
      function the_email_must_be_valid()
      {
          $this->from('usuarios/nuevo')->post('/usuarios/crear', [
              'name' => 'Usuario',
              'email' => 'correo-no-valido',
              'password' => '123456'
          ])->assertRedirect('usuarios/nuevo')
              ->assertSessionHasErrors(['email']);
  
          $this->assertEquals(0, User::count());
      }

       /** @test */
       function the_email_must_be_unique()
       {

            factory(User::class)->create([
                'email' => 'usuario@usuario.com'
            ]);

           $this->from('usuarios/nuevo')->post('/usuarios/crear', [
               'name' => 'Usuario',
               'email' => 'usuario@usuario.com',
               'password' => '123456'
           ])->assertRedirect('usuarios/nuevo')
               ->assertSessionHasErrors(['email']);
   
           $this->assertEquals(1, User::count());
       }

      /** @test */
      function the_password_is_required()
      {
          $this->from('usuarios/nuevo')->post('/usuarios/crear', [
              'name' => 'Usuario',
              'email' => 'usuario@usuario.com',
              'password' => ''
          ])->assertRedirect('usuarios/nuevo')
              ->assertSessionHasErrors(['password']);
  
          $this->assertEquals(0, User::count());
      }

      /** @test */
     function the_name_is_required_when_updating_a_user()
     {
        $user = factory(User::class)->create();

        $this->from("usuarios/{$user->id}/editar")->put("usuarios/{$user->id}", [
            'name' => '',
            'email' => 'usuario@usuario',
            'password' => '123456'
        ])->assertRedirect("usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('users', ['email' => 'usuario@usuario.com']);
     }

     /** @test */
    function the_email_is_required_when_updating_a_user()
    {
        $user = factory(User::class)->create();

        $this->from("usuarios/{$user->id}/editar")->put("usuarios/{$user->id}", [
             'name' => 'Usuario',
             'email' => '',
             'password' => '123456'
        ])->assertRedirect("usuarios/{$user->id}/editar")
             ->assertSessionHasErrors(['email']);
 
        $this->assertDatabaseMissing('users', ['email' => 'usuario@usuario.com']);
    }

      /** @test */
      function the_email_must_be_valid_when_updating_a_user()
      {
        $user = factory(User::class)->create();

        $this->from("usuarios/{$user->id}/editar")->put("usuarios/{$user->id}", [
              'name' => 'Usuario',
              'email' => 'correo-no-valido',
              'password' => '123456'
        ])->assertRedirect("usuarios/{$user->id}/editar")
              ->assertSessionHasErrors(['email']);
  
        $this->assertDatabaseMissing('users', ['email' => 'usuario@usuario.com']);
    }

       /** @test */
       function the_email_must_be_unique_when_updating_a_user()
       {

            $randomUser = factory(User::class)->create([
                'email' => 'otro@usuario.com'
            ]);

            $user = factory(User::class)->create([
                'email' => 'usuario@usuario.com'
            ]);

            $this->from("usuarios/{$user->id}/editar")->put("usuarios/{$user->id}", [
               'name' => 'Usuario',
               'email' => 'usuario@usuario.com',
               'password' => '123456'
        ])->assertRedirect("usuarios/{$user->id}");
   
        }

    /** @test */
    function the_password_is_optional_when_updating_a_user()
    {
        $oldPassword = 'CLAVE_ANTERIOR';
        $user = factory(User::class)->create([
            'password' => bcrypt($oldPassword)
        ]);

        $this->from("usuarios/{$user->id}/editar")->put("usuarios/{$user->id}", [
            'name' => 'Usuario',
            'email' => 'usuario@usuario.com',
            'password' => ''
        ])->assertRedirect("usuarios/{$user->id}");
          
        $this->assertCredentials([
            'name' => 'Usuario',
            'email' => 'usuario@usuario.com',
            'password' => $oldPassword
        ]);
    }

}
