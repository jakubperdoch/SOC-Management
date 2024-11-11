<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class AdminController extends Controller
{
    public function getProjectInfo(Request $request)
    {

        $project = Project::all();
        return response()->json($project, 200);
    }
}
