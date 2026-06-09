<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ProgramPloExport implements FromArray, WithStyles, WithEvents, ShouldAutoSize
{
    /** @var array  finalStudents structure from the controller            */
    protected $students;
    /** @var \Illuminate\Support\Collection  program-level PLOs            */
    protected $prog_plos;

    /* Header-strip metadata */
    protected $instituteName;
    protected $departmentName;
    protected $sessionName;
    protected $reportTitle = 'PLO Program Based Sheet';

    /* Layout constants — keeps the magic numbers in one place */
    const ROW_INSTITUTE   = 1;
    const ROW_DEPARTMENT  = 2;
    const ROW_SESSION     = 3;
    const ROW_SPACER      = 4;
    const ROW_TITLE       = 5;
    const ROW_COL_HEADER  = 6;
    const ROW_DATA_START  = 7;

    public function __construct(
        $students,
        $prog_plos,
        string $instituteName  = '—',
        string $departmentName = '—',
        string $sessionName    = '—'
    ) {
        $this->students       = $students;
        $this->prog_plos      = $prog_plos;
        $this->instituteName  = $instituteName;
        $this->departmentName = $departmentName;
        $this->sessionName    = $sessionName;
    }

    /* ============================================================
     |  Data — five reserved header rows, then col headers, then body
     |  ========================================================== */
    public function array(): array
    {
        $totalCols = 2 + $this->prog_plos->count();   // Name + Reg + N PLOs

        // Rows 1–5 are reserved for the merged header strip; we still
        // need full-width rows so the array shape stays consistent.
        $data = [];
        $data[] = $this->fullWidthRow('Institute: '  . $this->instituteName,  $totalCols);
        $data[] = $this->fullWidthRow('Department: ' . $this->departmentName, $totalCols);
        $data[] = $this->fullWidthRow('Session: '    . $this->sessionName,    $totalCols);
        $data[] = $this->fullWidthRow('',                                     $totalCols); // spacer
        $data[] = $this->fullWidthRow($this->reportTitle,                     $totalCols);

        // Row 6 — column headers
        $header = ['Name', 'Reg No'];
        foreach ($this->prog_plos as $plo) {
            $header[] = $plo->code;
        }
        $data[] = $header;

        // Row 7 onward — student rows
        foreach ($this->students as $student) {
            $row   = [];
            $row[] = $student['name'];
            $row[] = $student['reg_no'];

            foreach ($this->prog_plos as $plo) {
                if (isset($student['plos'][$plo->id])) {
                    $vals     = $student['plos'][$plo->id];
                    $sum      = array_sum(array_map(fn($v) => (float) $v['attainment'], $vals));
                    $count    = count($vals);
                    $divisor  = $count * 100;

                    $attainment = $divisor > 0
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

    private function fullWidthRow(string $value, int $totalCols): array
    {
        $row    = [$value];
        $row    = array_pad($row, $totalCols, '');
        return $row;
    }

    /* ============================================================
     |  WithStyles — base styles applied to the sheet
     |  ========================================================== */
    public function styles(Worksheet $sheet)
    {
        // Header strip — rows 1-5
        $sheet->getStyle('A' . self::ROW_INSTITUTE  . ':A' . self::ROW_SESSION)
              ->getFont()->setBold(true)->setSize(12);

        // Report title — row 5, larger and bolder
        $sheet->getStyle('A' . self::ROW_TITLE)
              ->getFont()->setBold(true)->setSize(16);

        return [];
    }

    /* ============================================================
     |  WithEvents — merging, headers, borders, conditional colours
     |  ========================================================== */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet     = $event->sheet->getDelegate();
                $totalCols = 2 + $this->prog_plos->count();
                $lastCol   = Coordinate::stringFromColumnIndex($totalCols);

                /* ---------- 1. Merge the 5 header rows full-width ---------- */
                foreach ([
                    self::ROW_INSTITUTE,
                    self::ROW_DEPARTMENT,
                    self::ROW_SESSION,
                    self::ROW_SPACER,
                    self::ROW_TITLE,
                ] as $r) {
                    $sheet->mergeCells("A{$r}:{$lastCol}{$r}");
                    $sheet->getStyle("A{$r}:{$lastCol}{$r}")
                          ->getAlignment()
                          ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                          ->setVertical(Alignment::VERTICAL_CENTER);
                }

                // Give the title row some breathing room
                $sheet->getRowDimension(self::ROW_TITLE)->setRowHeight(28);

                // Title colour accent
                $sheet->getStyle('A' . self::ROW_TITLE)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '4B0082']],
                ]);

                /* ---------- 2. Column header row (row 6) ---------- */
                $headerRange = "A" . self::ROW_COL_HEADER . ":{$lastCol}" . self::ROW_COL_HEADER;

                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size'  => 12,
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '6A1B9A'],   // deep purple
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => '4A148C'],
                        ],
                    ],
                ]);
                $sheet->getRowDimension(self::ROW_COL_HEADER)->setRowHeight(24);

                /* ---------- 3. Data table — borders + base alignment ---------- */
                $lastRow = $sheet->getHighestRow();

                if ($lastRow >= self::ROW_DATA_START) {
                    $dataRange = "A" . self::ROW_DATA_START . ":{$lastCol}{$lastRow}";

                    $sheet->getStyle($dataRange)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color'       => ['rgb' => 'B0BEC5'],
                            ],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ]);

                    // Center the PLO numeric columns (C onward), keep Name/Reg left-aligned
                    if ($totalCols > 2) {
                        $firstPloCol = Coordinate::stringFromColumnIndex(3);
                        $sheet->getStyle("{$firstPloCol}" . self::ROW_DATA_START . ":{$lastCol}{$lastRow}")
                              ->getAlignment()
                              ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }

                    /* ---------- 4. Conditional formatting — values < 50 ---------- */
                    // Walk only the PLO columns (col 3 to lastCol) to keep it fast.
                    for ($r = self::ROW_DATA_START; $r <= $lastRow; $r++) {
                        for ($c = 3; $c <= $totalCols; $c++) {
                            $coord = Coordinate::stringFromColumnIndex($c) . $r;
                            $val   = $sheet->getCell($coord)->getValue();

                            if (is_numeric($val) && (float) $val < 50) {
                                $sheet->getStyle($coord)->applyFromArray([
                                    'font' => [
                                        'bold'  => true,
                                        'color' => ['rgb' => 'B71C1C'], // strong red
                                    ],
                                    'fill' => [
                                        'fillType'   => Fill::FILL_SOLID,
                                        'startColor' => ['rgb' => 'FFEBEE'], // light red wash
                                    ],
                                ]);
                            }
                        }
                    }
                }

                /* ---------- 5. Visual separation between header strip & table ---------- */
                // Bottom border under the spacer row (row 4)
                $sheet->getStyle("A" . self::ROW_SPACER . ":{$lastCol}" . self::ROW_SPACER)
                      ->applyFromArray([
                          'borders' => [
                              'bottom' => [
                                  'borderStyle' => Border::BORDER_MEDIUM,
                                  'color'       => ['rgb' => '6A1B9A'],
                              ],
                          ],
                      ]);

                /* ---------- 6. Freeze panes so headers stay visible while scrolling ---------- */
                $sheet->freezePane('A' . self::ROW_DATA_START);

                /* ---------- 7. Sheet title ---------- */
                $sheet->setTitle('PLO Program Report');
            },
        ];
    }
}
