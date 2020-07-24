<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * The homepage.
     *
     * @method GET
     * @param  UserService $userService
     * @return Renderable
     */
    public function thirdIndex()
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
    public function thirdIndexServices(UserService $userService)
    {
        $users = $userService->findAdmins();
        return view('home', compact('users'));
    }
}
