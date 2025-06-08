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

    public function updateTeacher(Request $request)
    {
        $teacher = User::where('id', $request->id)->first();
        if (!$teacher) {
            return response()->json([
                'message' => 'Teacher not found.'
            ], 404);
        }

        $teacher->name = $request->name;
        $teacher->surname = $request->surname;
        $teacher->email = $request->email;
        $teacher->password = $request->password;
        $teacher->save();

        return response()->json([
            'message' => 'Teacher updated',
            'teacher' => [
                'id' => $teacher->id,
                'name' => $teacher->name,
                'surname' => $teacher->surname,
                'email' => $teacher->email,
                'role' => $teacher->role,
            ],
        ], 200);
    }

    public function deleteTeacher(Request $request)
    {
        $teacher = User::where('id', $request->id)->first();
        if (!$teacher) {
            return response()->json([
                'message' => 'Teacher not found.'
            ], 404);
        }

        $teacher->delete();

        return response()->json([
            'message' => 'Teacher deleted'
        ], 200);
    }

    public function getProjectInfo(Request $request)
    {
        $user = $request->user();
        $query = $request->query();
        $search = $query['search'] ?? '';

        $teacher = User::where('id', $user->id)->first();

        if (!$teacher) {
            return response()->json([
                'message' => 'Teacher not found.'
            ], 404);
        }

        $teacherName = $teacher->name . ' ' . $teacher->surname;

        $projects = !empty($search)
            ? Project::where('teacher_id', $user->id)->search($search)->get()
            : Project::where('teacher_id', $user->id)->get();


        if ($projects->isEmpty()) {
            return response()->json([
                'message' => 'Učitel nemá pridelené projekty.',
                'teacher' => $teacherName
            ], 200);
        }

        // Prepare projects with student details
        $projectsWithDetails = $projects->map(function ($project) {
            $student = User::where('id', $project->student_id)->first();

            return [
                'id' => $project->id,
                'title' => $project->title,
                'description' => $project->description,
                'status' => $project->status,
                'student' => $student ? $student->name . ' ' . $student->surname : null,
                'odbor' => $project->odbor,
            ];
        });

        $projects->each(function ($project) use (&$projectsCount) {
            $projectsCount[$project->status] = isset($projectsCount[$project->status]) ? $projectsCount[$project->status] + 1 : 1;
        });

        return response()->json([
            'message' => 'Teacher has assigned projects.',
            'teacher' => $teacherName,
            'projects' => $projectsWithDetails,
        ], 200);
    }
}
