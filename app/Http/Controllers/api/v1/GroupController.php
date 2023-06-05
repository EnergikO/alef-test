<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\v1\GroupWithStudentsAndLessonsResource;
use App\Models\Group;
use App\Serviceses\ResponseServise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public static function getGroups(Request $request): JsonResponse
    {
        return ResponseServise::successResponse([
            'groups' => GroupWithStudentsAndLessonsResource::collection(Group::all())
        ]);
    }

    public static function getGroupById(Request $request, string $id): JsonResponse
    {
        $group = Group::find($id);

        if (empty($group)) {
            return ResponseServise::notFoundResponse('group', 'id', $id);
        }

        return ResponseServise::successResponse([
            'group' => new GroupWithStudentsAndLessonsResource($group)
        ]);
    }

    public static function createGroup(GroupRequest $request): JsonResponse
    {
        $group = Group::create([
            'name' => $request->get('name'),
        ]);

        return ResponseServise::successResponse([
            'group' => new GroupWithStudentsAndLessonsResource($group)
        ]);
    }

    public static function updateGroup(GroupRequest $request, string $id): JsonResponse
    {
        $group = Group::find($id);

        if (empty($group)) {
            return ResponseServise::notFoundResponse('group', 'id', $id);
        }

        $group->name = $request->get('name');

        if (! $group->save()) {
            return ResponseServise::somethingWentWrongResponse();
        }

        return ResponseServise::successResponse([
            'group' => new GroupWithStudentsAndLessonsResource($group)
        ]);
    }

    public static function deleteGroup(Request $request, string $id): JsonResponse
    {
        $group = Group::with('students')->find($id);

        if (empty($group)) {
            return ResponseServise::notFoundResponse('group', 'id', $id);
        }

        if (! function ($group): bool {
            foreach ($group->students as $student) {
                $student->group_id = NULL;
            }

            return $group->delete();
        }) {
            return ResponseServise::somethingWentWrongResponse();
        }

        return ResponseServise::successResponse([
            'group' => new GroupWithStudentsAndLessonsResource($group)
        ]);
    }
}
