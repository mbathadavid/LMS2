<?php

namespace App\Exports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\FromCollection;

class SubjectExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Subject::all();
    }
}
