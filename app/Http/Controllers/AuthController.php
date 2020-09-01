<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return ['error' => 'Usuario não encontrado'];
        }

        if (Hash::check($request->password, $user->password)) {

            $user->load('roles');

            $token = JWTAuth::fromUser($user);

            $user['jwt'] = $token;

            return ['ok' => $user];
        }

        return ['error' => 'Sua senha esta incorreta'];

        // if (!$token = JWTAuth::attempt($credentials)) {
        //     return 'Invalid login details';
        // }

        // return $token;
    }



    public function register(Request $request)
    {

        $user = new User;

        $user->name = $request->name;

        $user->email = $request->email;

        $user->password = Hash::make($request->password);

        $user->save();

        $role = new Role;

        $role->role = $request->role ? $request->role : "visitante";

        $user->roles()->save($role);

        return ['ok'];
    }
}
