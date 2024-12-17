<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Deadline;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use DateTime;

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


    public function setProjectDeadline(Request $request)
    {
        //connection to database from table deadlines 
        $originalDate1 = $request->first_date;
        $date1 = DateTime::createFromFormat('d.m.Y', $originalDate1);
        $reversedDate1 = $date1->format('Y.m.d');

        $originalDate2 = $request->second_date;
        $date2 = DateTime::createFromFormat('d.m.Y', $originalDate2);
        $reversedDate2 = $date2->format('Y.m.d');

        $originalDate3 = $request->third_date;
        $date3 = DateTime::createFromFormat('d.m.Y', $originalDate3);
        $reversedDate3 = $date3->format('Y.m.d');



        $deadline = Deadline::where('id', 1)->first();
        $deadline->first_date = $reversedDate1;
        $deadline->second_date = $reversedDate2;
        $deadline->third_date = $reversedDate3;

        $deadline->save();

        return response()->json([
            'message' => 'Deadline updated',
            'deadline' => [
                'id' => $deadline->id,
                'first_date' => $deadline->first_date,
                'second_date' => $deadline->second_date,
                'third_date' => $deadline->third_date,
            ],
        ], 201);
    }

    public function getProjectDeadline(Request $request)
    {

        $deadline = Deadline::where('id', 1)->first();

        return response()->json([
            'message' => 'Deadliny',
            'deadline' => [
                'id' => $deadline->id,
                'first_date' => $deadline->first_date,
                'second_date' => $deadline->second_date,
                'third_date' => $deadline->third_date,
            ],
        ], 200);
    }

    public function addReview(Request $request)
    {
        //connection to database from table projects 
        $project = Project::where('id', $request->id)->first();
        if (!$project) {
            return response()->json([
                'message' => 'Project neexistuje',
            ], 404);
        }

        $project->first_review = $request->first_review;
        $project->second_review = $request->second_review;
        $project->third_review = $request->third_review;

        $project->save();

        return response()->json([
            'message' => 'Review added',
            'project' => [
                'id' => $project->id,
                'first_review' => $project->first_review,
                'second_review' => $project->second_review,
                'third_review' => $project->third_review,
            ],
        ], 200);


    }
}
