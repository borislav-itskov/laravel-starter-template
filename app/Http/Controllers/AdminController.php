<?php

namespace App\Http\Controllers;

use App\Models\Role;
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
        $adminRole = Role::whereName('Admin')->get()->first();
        $users = User::select('users.*')
            ->leftJoin('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->where('user_roles.role_id', '=', $adminRole->id)
            ->distinct()
            ->get()
        ;
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
