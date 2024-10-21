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
}
