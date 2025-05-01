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
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:accounts',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:student,teacher,admin',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
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
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Successfully logged in.',
                'access_token' => $token,
                'user' => $user,
            ], 200);
        } else {
            // If the credentials are incorrect, return an error message
            return response()->json(['message' => 'Nesprávne prihlasovacie údaje!'], 401);
        }
    }

    public function update(Request $request)
    {
        // Validate the request inputs
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255', // Added validation for surname
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Update the user in the accounts table
        $user = User::where('email', $request->email)->first();
        $user->name = $request->name;
        $user->surname = $request->surname; // Ensure this is included in the update
        $user->email = $request->email;
        $user->password = $request->password; // Plain text password (since you chose not to hash)
        $user->save();

        return response()->json([
            'message' => 'Úspešne ste aktualizovali svoje prihlasovacie údaje',
            'user' => $user,
        ], 200);
    }

    public function updateLogin(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:student,teacher,admin',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where('id',$id)->first();
        if (!$user) {
            return response()->json(['message' => 'User neexistuje'], 404);
        }

        $user->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ]);


        return response()->json([
            'message' => 'Úspešne ste aktualizovali svoje prihlasovacie údaje',
            'user' => $user,
        ], 200);
    }

    public function delete(Request $request)
    {
        // Delete the user from the accounts table
        $user = User::where('id', $request->id)->first();
        $user->delete();

        return response()->json([
            'message' => 'Úspešne ste odstránili svoj účet',
        ], 200);
    }

}
