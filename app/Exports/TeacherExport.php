<?php

namespace App\Exports;
use App\Exports\TeacherExport;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeacherExport implements FromCollection,WithHeadings
{
    public function headings():array{
        return [
        'Salutation',
        'First Name',
        'Second Name',
        'Last Name',
        'Gender',
        'Position',
        'Email',
        'Phone',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return Student::all();
        return collect(Teacher::getTeacher());
    }
}
