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
        // Find the teacher by their ID
        $teacher = User::where('id', $request->id)->first();

        if (!$teacher) {
            return response()->json([
                'message' => 'Teacher not found.'
            ], 404);
        }

        // Combine teacher name
        $teacherName = $teacher->name . ' ' . $teacher->surname;

        // Find all projects assigned to the teacher
        $projects = Project::where('teacher_id', $request->id)->get();

        if ($projects->isEmpty()) {
            return response()->json([
                'message' => 'Teacher has no assigned projects.',
                'teacher' => $teacherName
            ], 200);
        }

        // Prepare projects with student details
        $projectsWithDetails = $projects->map(function ($project) {
            $student = User::where('id', $project->student_id)->first();
            return [
                'project_details' => $project,
                'student' => $student ? $student->name . ' ' . $student->surname : null
            ];
        });

        return response()->json([
            'message' => 'Teacher has assigned projects.',
            'teacher' => $teacherName,
            'projects' => $projectsWithDetails
        ], 200);
    }
}
