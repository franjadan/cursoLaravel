<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeUserController extends Controller
{
    public function greetWithoutNickname($name) 
    {   
        $name = ucfirst($name);
        return "Bienvenido {$name}";   
    }

    public function greetWithNickname($name, $nickname) 
    {
        $name = ucfirst($name);
        return "Bienvenido {$name}, tu apodo es {$nickname}";
    }
}
