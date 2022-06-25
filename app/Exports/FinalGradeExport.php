<?php

namespace App\Exports;

use App\Models\FinalGrade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FinalGradeExport implements FromCollection,WithHeadings
{
    public function headings():array{
        
    }

    public function collection()
    {
        //
    }
}
