<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{

    public function getSingleProject(Request $request, $id)
    {
        $project = Project::where('id', $id)->first();

        if (!$project) {
            return response()->json([
                'message' => 'Projekt neexistuje'
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
                'student_id' => $project->student_id,
                'teacher_id' => $project->teacher_id,
                'odbor' => $project->odbor,
                'first_review' => $project->first_review,
                'second_review' => $project->second_review,
                'third_review' => $project->third_review,
                'mark' => $project->mark,
                'document' => $project->document ? url('storage/' . $project->document) : null,
                'presentation' => $project->presentation ? url('storage/' . $project->presentation) : null,
            ],
            'student' => $studentName,
            'teacher' => $teacherName
        ], 200);
    }

    public function getProject(Request $request, TeacherController $TeacherController, StudentController $StudentController, AdminController $AdminController)
    {

        $role = $request->user()->role;

        if ($role == 'teacher') {
            return $TeacherController->getProjectInfo($request);
        }
        if ($role == 'student') {
            return $StudentController->getProjectInfo($request);
        }
        if ($role == 'admin') {
            return $AdminController->getProjectInfo($request);
        }

        return response()->json([
            'message' => 'Rola neexistuje',
        ], 404);
    }

    public function createProject(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => [
                'required',
                Rule::in(['taken', 'free', 'waiting']),
            ],
            'teacher_id' => [
                'required',
                Rule::exists('users', 'id')
                    ->where(function ($query) {
                        $query->where('role', 'teacher')
                            ->orWhere('role', 'admin');
                    }),
            ],
            'odbor' => 'required|string|max:255',
            'student_id' => [
                'nullable',
                Rule::exists('users', 'id')
                    ->where('role', 'student'),
            ],
        ], [
            'title.required' => 'Názov projektu je povinný.',
            'description.required' => 'Popis projektu je povinný.',
            'status.required' => 'Status projektu je povinný.',
            'teacher_id.required' => 'ID učiteľa je povinné.',
            'odbor.required' => 'Odbor je povinný.',
            'student_id.exists' => 'Študent s týmto ID neexistuje.',
            'teacher_id.exists' => 'Učiteľ s týmto ID neexistuje.',
            'status.in' => 'Status musí byť jeden z: zabraný, voľný, čakajúci.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        $project = Project::create(
            [
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'student_id' => $request->student_id ?? null,
                'teacher_id' => $request->teacher_id,
                'odbor' => $request->odbor,
            ]
        );

        return response()->json([
            'message' => 'Projekt bol úspešne vytvorený',
            'project' => $project,
        ], 201);
    }


    public function updateProject(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => [
                'required',
                Rule::in(['taken', 'free', 'waiting']),
            ],
            'teacher_id' => [
                'required',
                Rule::exists('users', 'id')
                    ->where('role', 'teacher'),
            ],
            'odbor' => 'required|string|max:255',
            'student_id' => [
                'nullable',
                Rule::exists('users', 'id')
                    ->where('role', 'student'),
            ],
            'mark' => 'nullable|integer|between:1,5',
            'first_review' => 'nullable|string|max:1000',
            'second_review' => 'nullable|string|max:1000',
            'third_review' => 'nullable|string|max:1000',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:4096',
            'presentation' => 'nullable|file|mimes:ppt,pptx|max:4096',
        ], [
            'id.required' => 'ID projektu je povinné.',
            'id.exists' => 'Projekt s týmto ID neexistuje.',
            'title.required' => 'Názov projektu je povinný.',
            'description.required' => 'Popis projektu je povinný.',
            'status.required' => 'Status projektu je povinný.',
            'teacher_id.required' => 'ID učiteľa je povinné.',
            'odbor.required' => 'Odbor je povinný.',
            'student_id.exists' => 'Študent s týmto ID neexistuje.',
            'teacher_id.exists' => 'Učiteľ s týmto ID neexistuje.',
            'status.in' => 'Status musí byť jeden z: zabraný, voľný, čakajúci.',
            'mark.integer' => 'Značka musí byť celé číslo.',
            'mark.between' => 'Značka musí byť medzi 1 a 5.',
            'first_review.max' => 'Prvé hodnotenie nesmie presiahnuť 1000 znakov.',
            'second_review.max' => 'Druhé hodnotenie nesmie presiahnuť 1000 znakov.',
            'third_review.max' => 'Tretie hodnotenie nesmie presiahnuť 1000 znakov.',
            'document.file' => 'Dokument musí byť súbor.',
            'document.mimes' => 'Dokument musí byť vo formáte PDF, DOC alebo DOCX.',
            'document.max' => 'Dokument nesmie presiahnuť 4 MB.',
            'presentation.file' => 'Prezentácia musí byť súbor.',
            'presentation.mimes' => 'Prezentácia musí byť vo formáte PPT alebo PPTX.',
            'presentation.max' => 'Prezentácia nesmie presiahnuť 4 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $project = Project::find($request->id);
        if (!$project) {
            return response()->json([
                'message' => 'Projekt neexistuje',
            ], 404);
        }

        $project->update(
            [
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'student_id' => $request->student_id ?? null,
                'teacher_id' => $request->teacher_id,
                'odbor' => $request->odbor,
                'mark' => $request->mark,
                'first_review' => $request->first_review,
                'second_review' => $request->second_review,
                'third_review' => $request->third_review,
                'document' => $request->hasFile('document') ? $request->file('document')->store('documents') : $project->document,
                'presentation' => $request->hasFile('presentation') ? $request->file('presentation')->store('presentations') : $project->presentation,
            ]
        );

        return response()->json([
            'message' => 'Projekt bol úspešne aktualizovaný',
            'project' => $project,
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
        if ($project->document) {
            \Storage::delete($project->document);
        }
        if ($project->presentation) {
            \Storage::delete($project->presentation);
        }

        return response()->json([
            'message' => 'Projekt bol úspešne odstránený',
        ], 200);
    }


}
