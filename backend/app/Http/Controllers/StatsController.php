<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class StatsController extends Controller
{

    public function getStats(Request $request)
    {
        $user = $request->user();

        if($user->role =='teacher'){
            $projects = Project::where('teacher_id', $user->id)->get();
        } elseif ($user->role == 'student') {
            $projects = Project::where('student_id', $user->id)->get();
        } else {
            $projects = Project::all();
        }

        $projectsCount = [
            "Informatika" => 0,
            "Strojárstvo" => 0,
            "Elektrotechnika" => 0,
            "Logistika" => 0,
            "Učebné pomôcky" => 0,
        ];

        $projectsStats=[
            'overall' => 0,
            'openStatus' => 0,
            'waitingStatus' => 0,
            'takenStatus' => 0,
        ];

        $projects->each(function ($project) use (&$projectsCount, &$projectsStats) {
            $projectsCount[$project->odbor] = isset($projectsCount[$project->odbor]) ? $projectsCount[$project->odbor] + 1 : 1;
            $projectsStats['overall']++;

            if ($project->status == 'free') {
                $projectsStats['openStatus']++;
            } elseif ($project->status == 'waiting') {
                $projectsStats['waitingStatus']++;
            } elseif ($project->status == 'taken') {
                $projectsStats['takenStatus']++;
            }
        });

        return response()->json([
            'message' => 'Stats retrieved successfully.',
            'projectsCount' => array_values($projectsCount),
            'projectsStats' => $projectsStats,
        ]);
    }

}
