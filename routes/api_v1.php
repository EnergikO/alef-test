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
    Route::get('/{id}/lessons', [v1\GroupController::class, 'getGroupLessons'])->name('groups.get.lessons');
    Route::post('/', [v1\GroupController::class, 'createGroups'])->name('groups.create');
    Route::post('/{id}', [v1\GroupController::class, 'updateGroups'])->name('groups.update');
    Route::delete('/{id}', [v1\GroupController::class, 'deleteGroups'])->name('groups.delete');
});

Route::prefix('/lessons')->group(function () {
    Route::get('/', [v1\LessonController::class, 'getStudents'])->name('lessons.get.all');
    Route::get('/{id}', [v1\LessonController::class, 'getStudentById'])->name('lessons.get');
    Route::post('/', [v1\LessonController::class, 'createStudent'])->name('lessons.create');
    Route::post('/{id}', [v1\LessonController::class, 'updateStudent'])->name('lessons.update');
    Route::delete('/{id}', [v1\LessonController::class, 'deleteStudent'])->name('lessons.delete');
});
