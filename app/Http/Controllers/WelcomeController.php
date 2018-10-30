<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        return view('welcome');
    }
}
//this is a single action controller. WE use the magic method: __invoke.