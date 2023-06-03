<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\LessonWithStudentsAndGroupsResource;
use App\Models\Lesson;
use App\Serviceses\ResponseServise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public static function getGroups(Request $request): JsonResponse
    {
        return ResponseServise::successResponse([
            'lessons' => LessonWithStudentsAndGroupsResource::collection(Lesson::all())
        ]);
    }

    public static function getGroupById(Request $request, string $id): JsonResponse
    {
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            return ResponseServise::notFoundResponse('lesson', 'id', $id);
        }

        return ResponseServise::successResponse([
            'lesson' => new LessonWithStudentsAndGroupsResource($lesson)
        ]);
    }

    public static function createGroup(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
        ]);

        $lesson = Lesson::create([
            'topic' => $validated['topic'],
            'description' => $validated['description'],
        ]);

        return ResponseServise::successResponse([
            'lesson' => new LessonWithStudentsAndGroupsResource($lesson)
        ]);
    }

    public static function updateGroup(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:100',
            'description' => 'string|max:1000',
        ]);

        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            return ResponseServise::notFoundResponse('lesson', 'id', $id);
        }

        foreach ($validated as $key => $value) {
            $lesson->$key = $value;
        }

        if (! $lesson->save()) {
            return ResponseServise::somethingWentWrongResponse();
        }

        return ResponseServise::successResponse([
            'lesson' => new LessonWithStudentsAndGroupsResource($lesson)
        ]);
    }

    public static function deleteGroup(Request $request, string $id): JsonResponse
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
