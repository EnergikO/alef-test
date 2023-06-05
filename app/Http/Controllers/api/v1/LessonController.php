<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Http\Resources\v1\LessonWithStudentsAndGroupsResource;
use App\Models\Lesson;
use App\Serviceses\ResponseServise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public static function getLessons(Request $request): JsonResponse
    {
        return ResponseServise::successResponse([
            'lessons' => LessonWithStudentsAndGroupsResource::collection(Lesson::all())
        ]);
    }

    public static function getLessonById(Request $request, string $id): JsonResponse
    {
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            return ResponseServise::notFoundResponse('lesson', 'id', $id);
        }

        return ResponseServise::successResponse([
            'lesson' => new LessonWithStudentsAndGroupsResource($lesson)
        ]);
    }

    public static function createLesson(LessonRequest $request): JsonResponse
    {
        $lesson = Lesson::create([
            'topic' => $request->get('topic'),
            'description' => $request->get('description'),
        ]);

        return ResponseServise::successResponse([
            'lesson' => new LessonWithStudentsAndGroupsResource($lesson)
        ]);
    }

    public static function updateLesson(LessonRequest $request, string $id): JsonResponse
    {
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            return ResponseServise::notFoundResponse('lesson', 'id', $id);
        }

        $lesson->topic = $request->get('topic');
        $lesson->description = $request->get('description');

        if (! $lesson->save()) {
            return ResponseServise::somethingWentWrongResponse();
        }

        return ResponseServise::successResponse([
            'lesson' => new LessonWithStudentsAndGroupsResource($lesson)
        ]);
    }

    public static function deleteLesson(Request $request, string $id): JsonResponse
    {
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            return ResponseServise::notFoundResponse('lesson', 'id', $id);
        }

        if (! $lesson->delete()) {
            return ResponseServise::somethingWentWrongResponse();
        }

        return ResponseServise::successResponse([
            'lesson' => new LessonWithStudentsAndGroupsResource($lesson)
        ]);
    }
}
