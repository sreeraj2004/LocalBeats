<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Musician;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully!', 'user' => $user]);
    }

    public function registerMusician(Request $request)
{
    // Validation rules
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'band_name' => 'required|string|max:255',
        'genre' => 'required|string|max:255',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // If validation fails, return errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // Create the user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Create the musician profile
    $musician = Musician::create([
        'user_id' => $user->id,
        'band_name' => $request->band_name,
        'genre' => $request->genre,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Return success message
    return response()->json([
        'message' => 'Musician registered successfully!',
        'musician' => $musician
    ]);
}


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'user' => $user
        ]);
    }
}
