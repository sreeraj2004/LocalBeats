<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Musician;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['message' => 'User registered successfully!', 'user' => $user]);
        } catch (\Exception $e) {
            Log::error('User registration error: ' . $e->getMessage());
            return response()->json(['error' => 'Registration failed. Please try again.'], 500);
        }
    }

    public function registerMusician(Request $request)
    {
        try {
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
                'musician' => $musician,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('Musician registration error: ' . $e->getMessage());
            return response()->json(['error' => 'Registration failed. Please try again.'], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            Log::info('Login attempt:', [
                'email' => $request->email,
                'is_musician' => $request->is('login/musician'),
                'path' => $request->path()
            ]);

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                Log::warning('Login validation failed:', ['errors' => $validator->errors()]);
                return response()->json(['errors' => $validator->errors()], 400);
            }

            // Check if it's a musician login
            if ($request->is('login/musician')) {
                Log::info('Attempting musician login');
                $musician = Musician::where('email', $request->email)->first();

                if (!$musician) {
                    Log::warning('No musician found with email: ' . $request->email);
                    return response()->json(['error' => 'No musician account found with this email'], 401);
                }

                Log::info('Found musician:', ['id' => $musician->id, 'email' => $musician->email]);

                if (!Hash::check($request->password, $musician->password)) {
                    Log::warning('Invalid password for musician: ' . $musician->email);
                    return response()->json(['error' => 'Invalid password'], 401);
                }

                // Get associated user data
                $user = User::find($musician->user_id);

                if (!$user) {
                    Log::error('Associated user not found for musician: ' . $musician->id);
                    return response()->json(['error' => 'Associated user account not found'], 401);
                }

                Log::info('Musician login successful:', ['musician_id' => $musician->id, 'user_id' => $user->id]);

                return response()->json([
                    'message' => 'Login successful',
                    'user' => $user,
                    'musician' => $musician,
                    'isMusician' => true
                ]);
            }

            // Regular user login
            Log::info('Attempting user login');
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                Log::warning('No user found with email: ' . $request->email);
                return response()->json(['error' => 'No user found with this email'], 401);
            }

            if (!Hash::check($request->password, $user->password)) {
                Log::warning('Invalid password for user: ' . $user->email);
                return response()->json(['error' => 'Invalid password'], 401);
            }

            Log::info('User login successful:', ['user_id' => $user->id]);

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'isMusician' => false
            ]);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(['error' => 'Login failed. Please try again.'], 500);
        }
    }
}
