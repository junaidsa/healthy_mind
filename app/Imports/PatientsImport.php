<?php

namespace App\Imports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\ToModel;

class PatientsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Patient([
            'file_no'          => $row['file_no'],
            'registration_date' => $row['registration_date'],
            'first_name'       => $row['first_name'],
            'father_name'      => $row['father_name'],
            'gender'           => $row['gender'],
            'date_of_birth'    => $row['date_of_birth'],
            'uid_number'       => $row['uid_number'],
            'other_id'         => $row['other_id'],
            'mobile_no'        => $row['mobile_no'],
            'alternative_no'   => $row['alternative_no'],
            'address'          => $row['address'],
        ]);
    }
}
