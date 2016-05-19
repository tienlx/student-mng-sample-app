<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['id', 'title', 'description', 'value', 'teacher_id'];

    protected $hidden = ['create_at', 'update_at'];

    /**
     * A course is teached by one teacher
     */
    public function teacher()
    {
        return $this->belongsTo('App\Teacher');
    }

    /**
     * A course is taken by many student
     */
    public function students()
    {
        return $this->belongsToMany('App\Student');
    }
}


