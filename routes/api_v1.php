<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\v1;

Route::prefix('/students')->group(function () {
    Route::get('/', [v1\StudentController::class, 'getStudents'])->name('students.get.all');
    Route::get('/{id}', [v1\StudentController::class, 'getStudentById'])->name('students.get');
    Route::post('/', [v1\StudentController::class, 'createStudent'])->name('students.create');
    Route::post('/{id}', [v1\StudentController::class, 'updateStudent'])->name('students.update');
    Route::delete('/{id}', [v1\StudentController::class, 'deleteStudent'])->name('students.delete');
});

Route::prefix('/groups')->group(function () {
    Route::get('/', [v1\GroupController::class, 'getGroups'])->name('groups.get.all');
    Route::get('/{id}', [v1\GroupController::class, 'getGroupById'])->name('groups.get');
    Route::post('/', [v1\GroupController::class, 'createGroup'])->name('groups.create');
    Route::post('/{id}', [v1\GroupController::class, 'updateGroup'])->name('groups.update');
    Route::delete('/{id}', [v1\GroupController::class, 'deleteGroup'])->name('groups.delete');

    Route::get('/{id}/lessons', [v1\LessonController::class, 'getGroupLessons'])->name('groups.get.lessons');
});

Route::prefix('/lessons')->group(function () {
    Route::get('/', [v1\LessonController::class, 'getLessons'])->name('lessons.get.all');
    Route::get('/{id}', [v1\LessonController::class, 'getLessonById'])->name('lessons.get');
    Route::post('/', [v1\LessonController::class, 'createLesson'])->name('lessons.create');
    Route::post('/{id}', [v1\LessonController::class, 'updateLesson'])->name('lessons.update');
    Route::delete('/{id}', [v1\LessonController::class, 'deleteLesson'])->name('lessons.delete');
});
