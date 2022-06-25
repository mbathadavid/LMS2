<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;
    protected $fillable = ['classid','examid','subid','subject','AdmissionNo','Fname','Lname','marks','maxscore'];
}
