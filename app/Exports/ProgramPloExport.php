<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class ProgramPloExport implements FromArray

{



    protected $students;
    protected $prog_plos;

    public function __construct($students, $prog_plos)
    {
        $this->students = $students;
        $this->prog_plos = $prog_plos;
    }

    public function array(): array
    {
        $data = [];

        // Header Row
        $header = ['Name','Reg No'];

        foreach ($this->prog_plos as $plo) {
            $header[] = $plo->code;
        }

        $data[] = $header;

        foreach ($this->students as $student) {

            $row = [];
            $row[] = $student['name'];
            $row[] = $student['reg_no'];

            foreach ($this->prog_plos as $plo) {

                if(isset($student['plos'][$plo->id])){

                    $vals = $student['plos'][$plo->id];

                    $sum = array_sum(array_map(fn($v) => (float)$v['attainment'], $vals));
                    $count = count($vals);
                    $divisor = $count * 100;

                    $attainment = ($divisor > 0) 
                        ? round(($sum / $divisor) * 100, 2) 
                        : 0;

                    $row[] = $attainment;

                } else {
                    $row[] = '-';
                }
            }

            $data[] = $row;
        }

        return $data;
    }
    // protected $students;
    // protected $progPlos;

    // public function __construct($students, $progPlos)
    // {
    //     $this->students = $students;
    //     $this->progPlos = $progPlos;
    // }

    // public function collection()
    // {
    //     $rows = [];

    //     foreach ($this->students as $student) {
    //         $row = [
    //             $student['name'],
    //             $student['reg_no'],
    //         ];

    //         foreach ($this->progPlos as $plo) {
    //             $attainments = $student['plos'][$plo->id] ?? [];

    //             if (count($attainments)) {
    //                 $sum = array_sum(array_map('floatval', $attainments));
    //                 $count = count($attainments);
    //                 $normalized = ($sum / ($count * 100)) * 100;
    //                 $row[] = number_format($normalized, 2); // Final PLO percentage
    //             } else {
    //                 $row[] = '-';
    //             }
    //         }

    //         $rows[] = collect($row);
    //     }

    //     return collect($rows);
    // }

    // public function headings(): array
    // {
    //     $headings = ['Student Name', 'Registration No'];
    //     foreach ($this->progPlos as $plo) {
    //         $headings[] = $plo->code; // like PLO1, PLO2
    //     }
    //     return $headings;
    // }
}
