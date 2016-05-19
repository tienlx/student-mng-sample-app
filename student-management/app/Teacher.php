<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['id', 'name', 'address', 'phone', 'profession'];

    protected $hidden = ['create_at', 'update_at'];

    /**
     * A teacher teaches many courses
     */
    public function courses()
    {
        return $this->hasMany('App\Course');
    }
}


