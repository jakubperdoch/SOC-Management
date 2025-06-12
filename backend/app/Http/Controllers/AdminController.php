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
                'id' => $project->id,
                'title' => $project->title,
                'description' => $project->description,
                'status' => $project->status,
                'odbor' => $project->odbor,
                'first_review' => $project->first_review,
                'second_review' => $project->second_review,
                'third_review' => $project->third_review,
                'mark' => $project->mark,
                'document' => $project->document ? url('storage/' . $project->document) : null,
                'presentation' => $project->presentation ? url('storage/' . $project->presentation) : null,
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


    public function exportDatabase(Request $request)
    {
        $databaseName = env('DB_DATABASE');
        $userName = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $mysqldump = exec('which mysqldump');


        $command = "{$mysqldump} --user={$userName} --password={$password} {$databaseName} > backup.sql";
        $output = [];
        $returnVar = 0;
        exec($command, $output, $returnVar);
        if ($returnVar !== 0) {
            return response()->json(['message' => 'Failed to export the database.'], 500);
        }
        return response()->download('backup.sql')->deleteFileAfterSend(true);
    }
}
