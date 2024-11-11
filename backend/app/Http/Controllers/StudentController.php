<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;

class StudentController extends Controller
{
    public function getStudent(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Student neexistuje',
            ], 404);
        }

        return response()->json([
            'message' => 'Student existuje',
            'user' => [
                'name' => $user->name,
                'surname' => $user->surname,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ], 200);
    }

    public function getProjectInfo(Request $request)
    {
        $project = Project::where('student', $request->id)->get();
        return response()->json($project, 200);
    }
}
