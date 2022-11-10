<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * The homepage.
     *
     * @method GET
     * @return Renderable
     */
    public function index()
    {
        return view('welcome');
    }
}
