<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;

class ProjectController extends Controller
{

    public function getSingleProject(Request $request)
    {
        // Fetch the project from the database
        $project = Project::where('id', $request->id)->first();

        // Check if the project exists
        if (!$project) {
            return response()->json([
                'message' => 'Project neexistuje', // Project does not exist
            ], 404);
        }

        // Fetch the associated student and teacher
        $student = User::where('id', $project->student_id)->first();
        $teacher = User::where('id', $project->teacher_id)->first();

        // Prepare student and teacher names
        $studentName = $student ? $student->name . ' ' . $student->surname : null;
        $teacherName = $teacher ? $teacher->name . ' ' . $teacher->surname : null;




        return response()->json([
            'message' => 'Project existuje',
            'project' => [
                'id' => $project->id,
                'title' => $project->title,
                'description' => $project->description,
                'status' => $project->status,
                'student' => $project->student_id,
                'teacher' => $project->teacher_id,
                'odbor' => $project->odbor,
            ],
            'student' => $studentName,
            'teacher' => $teacherName
        ], 200);
    }

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
        $project->title = $request->title;
        $project->description = $request->description;
        $project->status = $request->status;
        $project->student_id = $request->student_id;
        $project->teacher_id = $request->teacher_id;
        $project->odbor = $request->odbor;
        $project->save();

        return response()->json([
            'message' => 'Project created',
            'project' => [
                'id' => $project->id,
                'name' => $project->title,
                'description' => $project->description,
                'status' => $project->status,
                'student' => $project->student_id,
                'teacher' => $project->teacher_id,
                'odbor' => $project->odbor,
            ],
        ], 201);
    }

    public function updateProject(Request $request)
    {
        //connection to database from table projects 
        $project = Project::where('id', $request->id)->first();
        if (!$project) {
            return response()->json([
                'message' => 'Project neexistuje',
            ], 404);
        }

        $project->title = $request->title;
        $project->description = $request->description;
        $project->status = $request->status;
        $project->student_id = $request->student_id;
        $project->teacher_id = $request->teacher_id;
        $project->odbor = $request->odbor;
        $project->save();

        return response()->json([
            'message' => 'Project updated',
            'project' => [
                'id' => $project->id,
                'name' => $project->title,
                'description' => $project->description,
                'status' => $project->status,
                'student' => $project->student_id,
                'teacher' => $project->teacher_id,
                'odbor' => $project->odbor,
            ],
        ], 200);
    }

    public function deleteProject(Request $request)
    {
        //connection to database from table projects 
        $project = Project::where('id', $request->id)->first();
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
