<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return response()->json([
                'message' => 'User neexistuje',
            ], 404);
        }



        return response()->json([
            'message' => 'User existuje',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'surname' => $user->surname,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ], 200);
    }

    public function getUsers(Request $request, $role)
    {
        if ($role =='all') {
            $users = User::paginate(10);
        } else {
            $users = User::where('role', $role)->paginate(10);
        }

        return response()->json($users, 200);
    }
}
