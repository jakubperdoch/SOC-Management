<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUser(Request $request,$id)
    {
        $user = User::where('id', $id)->first();
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
                'password' => $user->password,
                'role' => $user->role,
            ],
        ], 200);
    }

    public function getUsers(Request $request, $role)
    {
        $search = $request->query('search', '');

        $users = User::query()
            ->when($role !== 'all', function ($q) use ($role) {
                $q->where('role', $role);
            })

            ->when($search, function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name',    'LIKE', "%{$search}%")
                        ->orWhere('surname', 'LIKE', "%{$search}%")
                        ->orWhere('email',   'LIKE', "%{$search}%");
                });
            })
            ->paginate(16);

        return response()->json($users, 200);
    }
}
