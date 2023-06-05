<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'lessons';

    protected $fillable = ['topic', 'description'];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_lessons', 'lesson_id', 'group_id');
    }

    public function auditionedGroups()
    {
        return $this->groups()->whereStatus(1);
    }
}
