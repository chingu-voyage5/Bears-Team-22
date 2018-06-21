<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exercise;

class ExerciseController extends Controller
{

  public function index(Request $request)
  {
    $exercises = Exercise::all();
    return view('exercises.index', compact('exercises'));
  }

  public function create()
  {
      return view('excercises.create');
  }


}
