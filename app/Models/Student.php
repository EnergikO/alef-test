<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'group_id'];

    public function group(): HasOne
    {
        return $this->hasOne(Group::class);
    }

    public function listenedLessons(): \Illuminate\Support\Collection
    {
        return GroupLesson::whereGroupId($this->group->id)->whereStatus(1)->get();
    }
}
