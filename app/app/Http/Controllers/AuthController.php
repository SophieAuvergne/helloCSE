<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthRequest $request): JsonResponse
    {
        //on trouve l'utilisateur via l'email (car unique)
        $admin = Admin::where('email', $request->email)->first();

        /** @var string $password */
        $password = $request->password;

        //vérification du mot de passe
        if (!$admin || !Hash::check($password, $admin->password)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        //création du token d'iddentification
        $token = $admin->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
