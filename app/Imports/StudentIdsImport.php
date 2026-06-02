<?php

namespace App\Imports;

use App\Models\EnrollStudent;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentIdsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new EnrollStudent([
            //
        ]);
    }
}
