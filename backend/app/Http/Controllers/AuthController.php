<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        // Validate the request inputs
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255', // Added validation for surname
            'email' => 'required|string|email|max:255|unique:accounts',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create the user in the accounts table
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname, // Ensure this is included in the insert
            'email' => $request->email,
            'password' => $request->password, // Plain text password (since you chose not to hash)
        ]);

        return response()->json([
            'message' => 'Úspešne ste registrovaný',
            'user' => $user,
        ], 201);
    }


    // Login a user
    public function login(Request $request)
    {
        // Validate the request inputs
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if the user with the given email exists
        $user = User::where('email', $credentials['email'])->first();

        // If the user exists, verify the password without hashing
        if ($user && $credentials['password'] === $user->password) {
            // If the credentials are correct, return user data and a success message
            return response()->json([
                'message' => 'Úspešne ste boli prihlásený!',
                'user' => [
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'email' => $user->email,
                ],
            ], 200);
        } else {
            // If the credentials are incorrect, return an error message
            return response()->json(['message' => 'Nesprávne prihlasovacie údaje!'], 401);
        }
    }

}
