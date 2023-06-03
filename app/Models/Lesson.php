<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['topic', 'description'];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function listenedLessons(): \Illuminate\Support\Collection
    {
        return GroupLesson::whereGroupId($this->group->id)->whereStatus(1)->get();
    }
}
