<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profession;

class ProfessionController extends Controller
{
    public function index()
    {
        $professions = Profession::query()
            ->withCount('profiles')
            ->orderBy('title')->
            get();

        return view('professions.index', [
            'title' => 'Profesiones',
            'professions' => $professions
        ]);
    }

    public function destroy(Profession $profession)
    {

        abort_if($profession->profiles()->exists(), 400, 'No se puede eliminar una profesión asociada a un usuario');

        $profession->delete();

        return redirect(route('professions.index'));
    }
}
