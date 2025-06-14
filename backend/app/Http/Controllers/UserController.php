<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getUser(Request $request, $id)
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
        $additionalRoles = $request->query('additionalRoles', '');

        $users = User::query()
            ->when($additionalRoles, function ($q) use ($additionalRoles, $role) {
                $roles = explode(',', $additionalRoles);
                $roles = array_merge([$role], $roles);
                $q->whereIn('role', $roles);
            })
            ->when(!$additionalRoles && $role !== 'all', function ($q) use ($role) {
                $q->where('role', $role);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('surname', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                });
            })
            ->paginate(16);

        return response()->json($users, 200);
    }

    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'role' => 'required|string|in:student,teacher,admin',
        ], [
                'name.required' => 'Meno je povinné.',
                'surname.required' => 'Priezvisko je povinné.',
                'email.required' => 'Email je povinný.',
                'email.email' => 'Email musí byť platný email.',
                'role.required' => 'Rola je povinná.',
                
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where('id', $id)->first();
        if (!$user) {
            return response()->json(['message' => 'User neexistuje'], 404);
        }

        $user->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'role' => $request->role,
        ]);


        return response()->json([
            'message' => 'Úspešne ste aktualizovali svoje prihlasovacie údaje',
            'user' => $user,
        ], 200);
    }


    public function deleteUser(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->delete();

        return response()->json([
            'message' => 'Úspešne ste odstránili svoj účet',
        ], 200);
    }


}
