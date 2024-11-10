<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    //
    public function getProject(Request $request)
    {
        //connection to database from table projects 
        $project = Project::where('title', $request->name)->first();
        if (!$project) {
            return response()->json([
                'message' => 'Project neexistuje',
            ], 404);
        }

        return response()->json([
            'message' => 'Jop projekt existuje',
            'project' => [
                'name' => $project->title,
                'description' => $project->description,
                'status' => $project->status,
                'student' => $project->student,
                'teacher' => $project->teacher,
            ],
        ], 200);
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
}
