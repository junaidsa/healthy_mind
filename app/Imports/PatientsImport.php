<?php

namespace App\Imports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PatientsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Patient([
            'file_no'           => $row['file_no'],
            'registration_date' => $row['registration_date'],
            'first_name'        => $row['first_name'],
            'father_name'       => $row['father_name'],
            'gender'            => $row['gender'],
            'uid_number'        => $row['uid_number'],
            'date_of_birth'     => $row['date_of_birth'],
            'mobile_no'         => $row['mobile_no'],
            'address'           => $row['address'],
        ]);
    }
}
