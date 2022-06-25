<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';

    public static function getStudent(){
        $records = DB::table('students')->get()->toArray();

        return $records;
    }
}
