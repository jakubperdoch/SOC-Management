<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class AdminController extends Controller
{
    public function getProjectInfo(Request $request)
    {

        $projects = Project::all();
        $query = $request->query();
        $search = $query['search'] ?? '';

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

        // Filter projects based on the search query
        if (!empty($search)) {
            $projectsWithDetails = $projectsWithDetails->filter(function ($project) use ($search) {
                return str_contains($project['project_details']->title, $search);
            });
        }

        return response()->json([
            'message' => 'All projects with their details.',
            'projects' => $projectsWithDetails,
        ]);
    }
}
