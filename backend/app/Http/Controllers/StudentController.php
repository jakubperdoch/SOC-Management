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
        $studentProject = Project::where('student_id', $request->id)->first();

        if ($studentProject) {
            // If the student has a project, return it as a JSON response
            return response()->json([
                'message' => 'Student already has a project.',
                'project' => $studentProject
            ]);
        } else {
            // If no project is assigned, get all projects without a student assigned
            $unassignedProjects = Project::where('status', "free")->get();

            return response()->json([
                'message' => 'No project assigned to this student. Here are the unassigned projects.',
                'projects' => $unassignedProjects
            ]);
        }

    }

}
