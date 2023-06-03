<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\StudentWithLessonsResource;
use App\Serviceses\ResponseServise;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Student;

class StudentController extends Controller
{
    public static function getStudents(Request $request): JsonResponse
    {
        return ResponseServise::successResponse([
            'students' => StudentWithLessonsResource::collection(Student::all())
        ]);
    }

    public static function getStudentById(Request $request, string $id): JsonResponse
    {
        $student = Student::find($id);

        if (empty($student)) {
            return ResponseServise::notFoundResponse('student', 'id', $id);
        }

        return ResponseServise::successResponse([
            'student' => new StudentWithLessonsResource($student)
        ]);
    }

    public static function createStudent(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:students',
            'group_id' => 'numeric|exists:groups,id'
        ]);

        $student = Student::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'group_id' => $validated['group_id'],
        ]);

        return ResponseServise::successResponse([
            'student' => new StudentWithLessonsResource($student)
        ]);
    }

    public static function updateStudent(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => "email|unique:students,email,$id",
            'group_id' => 'numeric|exists:groups,id'
        ]);

        $student = Student::find($id);

        if (empty($student)) {
            return ResponseServise::notFoundResponse('student', 'id', $id);
        }

        foreach ($validated as $key => $value) {
            $student->$key = $value;
        }

        if (! $student->save()) {
            return ResponseServise::somethingWentWrongResponse();
        }

        return ResponseServise::successResponse([
            'student' => new StudentWithLessonsResource($student)
        ]);
    }

    public static function deleteStudent(Request $request, string $id): JsonResponse
    {
        $student = Student::find($id);

        if (empty($student)) {
            return ResponseServise::notFoundResponse('student', 'id', $id);
        }

        if (! $student->delete()) {
            return ResponseServise::somethingWentWrongResponse();
        }

        return ResponseServise::successResponse([
            'student' => new StudentWithLessonsResource($student)
        ]);
    }
}
