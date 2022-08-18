<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        $userLogged = auth()->user();
        $users = User::where('id', '!=', $userLogged->id)->get();

        return response()->json([
            'users' => $users
        ], Response::HTTP_OK);
    }

    public function me()
    {
        return response()->json([
            'user' => auth()->user()
        ], Response::HTTP_OK);
    }


    public function show(User $user)
    {
        return response()->json([
            'user' => $user
        ], Response::HTTP_OK);
    }
}
