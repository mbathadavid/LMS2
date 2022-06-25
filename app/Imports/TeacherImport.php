<?php

namespace App\Imports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeacherImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Teacher([
            'salutation' => $row['salutation'],
            'Fname' => $row['first_name'],
            'Sname' => $row['second_name'],
            'Lname' => $row['last_name'],
            'Gender' => $row['gender'],
            'Position' => $row['position'],
            'Email' => $row['email'],
            'Phone' => $row['phone']
        ]);
    }
}
