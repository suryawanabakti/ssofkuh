<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SSOController extends Controller
{
    public function getSSOByUsername($username)
    {
        $user = User::where('username', $username)->first();
        if ($user) {
            return response()->json([
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'user sso tidak ada',
            ], 404);
        }
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'username' => ['required', 'unique:users,username'],
            'name' => ['required'],
            'password' => ['required', 'min:5'],
        ]);

        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);
        $user->assignRole('user');
        return response()->json([
            'message' => 'Berhasil tambah user',
        ], 200);
    }
}
