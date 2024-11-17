<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use SebastianBergmann\CodeUnit\FunctionUnit;

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

    public function createTeacher(Request $request)
    {
        $teacher = new User();
        $teacher->name = $request->name;
        $teacher->surname = $request->surname;
        $teacher->email = $request->email;
        $teacher->password = $request->password;
        $teacher->role = 'teacher';
        $teacher->save();

        return response()->json([
            'message' => 'Teacher created',
            'teacher' => [
                'id' => $teacher->id,
                'name' => $teacher->name,
                'surname' => $teacher->surname,
                'email' => $teacher->email,
                'role' => $teacher->role,
            ],
        ], 201);
    }

    public function getProjectInfo(Request $request)
    {
        $project = Project::where('teacher', $request->id)->get();
        return response()->json($project, 200);
    }
}
