<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;

class TeacherController extends Controller
{
    public function getTeacher(Request $request)
    {
        $teacher = User::where('id', $request->id)->first();
        if (!$teacher) {
            return response()->json([
                'message' => 'Teacher neexistuje',
            ], 404);
        }

        return response()->json([
            'message' => 'Teacher existuje',
            'teacher' => [
                'name' => $teacher->name,
                'surname' => $teacher->surname,
                'email' => $teacher->email,
                'role' => $teacher->role,
            ],
        ], 200);
    }

    public function getProjectInfo(Request $request)
    {
        $project = Project::where('teacher', $request->id)->get();
        return response()->json($project, 200);
    }
}
