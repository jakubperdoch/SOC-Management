<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;


class StudentController extends Controller
{
    public function getStudent(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Student neexistuje',
            ], 404);
        }

        return response()->json([
            'message' => 'Student existuje',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'surname' => $user->surname,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ], 200);
    }

    public function getProjectInfo(Request $request)
    {

        $user = $request->user();
        $studentProject = Project::where('student_id', $user->id)->first();

        $student = User::where('id', $request->id)->first();

        $teacher = $studentProject ? User::where('id', $studentProject->teacher_id)->first() : null;

        $studentName = $student ? $student->name . ' ' . $student->surname : null;
        $teacherName = $teacher ? $teacher->name . ' ' . $teacher->surname : null;

        if ($studentProject) {
            // If the student has a project, return it as a JSON response
            return response()->json([
                'message' => 'Student already has a project.',
                'project_details' => $studentProject,
                'student' => $studentName,
                'teacher' => $teacherName
            ]);
        } else {

            $projects = Project::all();

            $projectsWithDetails = $projects->map(function ($project) {
                // Fetch the student and teacher for each project
                $student = User::where('id', $project->student_id)->first();
                $teacher = User::where('id', $project->teacher_id)->first();

                return [
                    'project_details' => $project,
                    'student' => $student ? $student->name . ' ' . $student->surname : null,
                    'teacher' => $teacher ? $teacher->name . ' ' . $teacher->surname : null,
                ];
            });

            return response()->json([
                'message' => 'No project assigned to this student. Here are the unassigned projects.',
                'projects' => $projectsWithDetails,
            ]);
        }

    }

}
