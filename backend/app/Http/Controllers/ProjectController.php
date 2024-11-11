<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;

class ProjectController extends Controller
{
    //
    public function getProject(Request $request, TeacherController $TeacherController, StudentController $StudentController, AdminController $AdminController)
    {
        //connection to database from table projects 
        $role = $request->role;
        if ($role == 'teacher') {
            return $TeacherController->getProjectInfo($request);
        }
        if ($role == 'student') {
            return $StudentController->getProjectInfo($request);
        }
        if ($role == 'admin') {
            return $AdminController->getProjectInfo($request);
        }
    }

    public function createProject(Request $request)
    {
        //connection to database from table projects 
        $project = new Project();
        $project->title = $request->name;
        $project->description = $request->description;
        $project->status = $request->status;
        $project->student = $request->student;
        $project->teacher = $request->teacher;
        $project->save();

        return response()->json([
            'message' => 'Project created',
            'project' => [
                'name' => $project->title,
                'description' => $project->description,
                'status' => $project->status,
                'student' => $project->student,
                'teacher' => $project->teacher,
            ],
        ], 201);
    }

    public function updateProject(Request $request)
    {
        //connection to database from table projects 
        $project = Project::where('title', $request->name)->first();
        if (!$project) {
            return response()->json([
                'message' => 'Project neexistuje',
            ], 404);
        }

        $project->description = $request->description;
        $project->status = $request->status;
        $project->student = $request->student;
        $project->teacher = $request->teacher;
        $project->save();

        return response()->json([
            'message' => 'Project updated',
            'project' => [
                'name' => $project->title,
                'description' => $project->description,
                'status' => $project->status,
                'student' => $project->student,
                'teacher' => $project->teacher,
            ],
        ], 200);
    }

    public function deleteProject(Request $request)
    {
        //connection to database from table projects 
        $project = Project::where('title', $request->name)->first();
        if (!$project) {
            return response()->json([
                'message' => 'Project neexistuje',
            ], 404);
        }

        $project->delete();

        return response()->json([
            'message' => 'Project deleted',
        ], 200);
    }


}
