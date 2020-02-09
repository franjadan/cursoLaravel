<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Skill;

class SkillController extends Controller
{
    public function index()
    {
        return view('skills.index', [
            'title' => 'Habilidades',
            'skills' => Skill::orderBy('name')->get()
        ]);
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect(route('skills.index'));
    }
}
