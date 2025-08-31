<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'category',
        'difficulty',
        'duration',
        'max_students',
        'prerequisites',
        'learning_objectives',
        'instructor_id',
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->ordered();
    }

    public function publishedModules()
    {
        return $this->hasMany(Module::class)->published()->ordered();
    }
}
