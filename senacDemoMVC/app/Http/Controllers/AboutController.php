<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function sobre() {
       // return 'Olá Mundo!';
       return view('sobre');
    }
}
