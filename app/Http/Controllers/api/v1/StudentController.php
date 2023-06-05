<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
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

    public static function createStudent(StudentRequest $request): JsonResponse
    {
        $student = Student::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'group_id' => $request->get('group_id'),
        ]);

        return ResponseServise::successResponse([
            'student' => new StudentWithLessonsResource($student)
        ]);
    }

    public static function updateStudent(StudentRequest $request, string $id): JsonResponse
    {
        $student = Student::find($id);

        if (empty($student)) {
            return ResponseServise::notFoundResponse('student', 'id', $id);
        }

        $student->name = $request->get('name');
        $student->email = $request->get('email');
        $student->group_id = $request->get('group_id');

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
