<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['id', 'name', 'address', 'phone', 'career'];

    protected $hidden = ['create_at', 'update_at'];

    /**
     * A student takes many courses
     */
    public function courses()
    {
        return $this->belongsToMany('App\Course');
    }
}


