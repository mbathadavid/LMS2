<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teacher extends Model
{
    use HasFactory;
    protected $table = 'teachers';
    protected $fillable = ['salutation','Fname','Sname','Lname','Gender','Position','Email','Phone'];
    

    public static function getTeacher(){
        $teachers = DB::table('teachers')->select('salutation','Fname','Sname','Lname','Gender','Position','Email','Phone')->get()->toArray();

        return $teachers;
    }
    public static function getTeachersTemplate(){
        //$teachers = DB::table('teachers')->select('salutation','Fname','Sname','Lname','Gender','Position','Email','Phone')->get()->toArray();
        $teachers = [];
        return $teachers;
    }
}
