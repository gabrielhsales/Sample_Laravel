<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth.role:admin', ['only' => ['blockUser']]);
    }

    public function blockUser()
    {
        $users = User::all();

        return $users->load('roles');
    }
    public function profile()
    {
        return 'Rota somente para visitante.';
    }
}
