<?php

namespace App\Exports;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class TeachertemplateExport implements FromCollection,WithHeadings
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
        return collect(Teacher::getTeachersTemplate());
    }
}
