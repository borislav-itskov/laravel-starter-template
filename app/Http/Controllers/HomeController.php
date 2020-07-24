<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    public function index()
    {
        $users = User::whereIsAdmin(1)->get();
        return view('home', compact('users'));
    }

    /**
     * The homepage, service edition
     *
     * @method GET
     * @param  UserService $userService
     * @return Renderable
     */
    public function indexServices(UserService $userService)
    {
        $users = $userService->findAdmins();
        return view('home', compact('users'));
    }

    /**
     * The homepage.
     *
     * @method GET
     * @param  UserService $userService
     * @return Renderable
     */
    public function secondIndex()
    {
        $users = User::whereIsAdmin(1)->get();
        return view('home', compact('users'));
    }

    /**
     * The homepage, service edition
     *
     * @method GET
     * @param  UserService $userService
     * @return Renderable
     */
    public function secondIndexServices(UserService $userService)
    {
        $users = $userService->findAdmins();
        return view('home', compact('users'));
    }
}
