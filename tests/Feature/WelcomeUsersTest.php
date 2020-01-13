<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeUsersTest extends TestCase
{
    /** @test */
    function it_welcome_users_with_nickname()
    {
        $this->get('saludo/francisco/adan')
            ->assertStatus(200)
            ->assertSee("Bienvenido Francisco, tu apodo es adan");
    }

    /** @test */
    function it_welcome_users_without_nickname()
    {
        $this->get('saludo/francisco')
            ->assertStatus(200)
            ->assertSee("Bienvenido Francisco");
    }
}
