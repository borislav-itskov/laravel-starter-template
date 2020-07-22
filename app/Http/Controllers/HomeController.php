<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * The homepage.
     *
     * @method GET
     * @param  UserService $userService
     * @return Renderable
     */
    public function index(UserService $userService)
    {
        $users = $userService->findAll();
        return view('welcome');
    }
}
