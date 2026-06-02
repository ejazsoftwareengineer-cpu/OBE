<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CourseStatusExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Course Name',
            'Code',
            'Section',
            'Instructor',
            // 'CLOs',
            // 'PLOs',
            'Total Students Enrolled',
            'Total Questions',
            'Attempted Percentage (%)'
        ];
    }
}
