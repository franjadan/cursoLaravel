<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    /** @test */
    function it_loads_the_user_list_page()
    {
        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('Usuarios')
            ->assertSee('Joel')
            ->assertSee('Ellie')
            ->assertSee('Tess')
            ->assertSee('Tommy')
            ->assertSee('Bill');
    }
    
    /** @test */
    function it_loads_the_users_detail_page()
    {
        $this->get("/usuarios/5")
            ->assertStatus(200)
            ->assertSee('Mostrando detalle del usuario: 5');
    }

    /** @test */
    function it_loads_the_new_users_page()
    {
        $this->get('usuarios/nuevo')
        ->assertStatus(200)
        ->assertSee('Crear nuevo usuario');
    }

    /** @test */
    function it_loads_the_user_edit_page()
    {
        $this->get('usuarios/5/edit')
            ->assertStatus(200)
            ->assertSee('Editando al usuario 5');
    }
}
