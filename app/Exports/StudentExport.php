<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection,WithHeadings
{
    public function headings():array{
        return [
        '#',
        'FirstName',
        'Second Name',
        'Last Name',
        'Admission No.',
        'Class',
        'Gender',
        'DoB',
        'Status',
        'County',
        'SubCounty',
        'Disabled?',
        'Disability',
        'Description',
        'Image',
        'created_at',
        'updated_at'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Student::all());
        //return Student::all();
        //return collect(Student::getStudent());
    }
}
