<?php

namespace App\Exports;

use App\Models\Promocion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class EstudiantesExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $promocion;
    protected bool $isKorean;

    public function __construct(Promocion $promocion)
    {
        $this->promocion = $promocion;
        $this->isKorean  = app()->getLocale() === 'ko';
    }

    public function collection()
    {
        return $this->promocion->estudiantes()
            ->orderBy('nombre_completo')
            ->get()
            ->map(function ($e) {
                return [
                    $e->translated('nombre_completo'),
                    $e->translated('quien_invito'),
                    $e->translated('relacion_con_quien_invito'),
                    $e->translated('evangelista_encargada'),
                    $e->edad,
                    $e->fecha_nacimiento ? $e->fecha_nacimiento : '',
                    $e->translated('nacionalidad'),
                    $e->email,
                    $e->telefono,
                    $e->translated('conoce_estudiantes'),
                ];
            });
    }

    public function headings(): array
    {
        if ($this->isKorean) {
            return [
                '이름',
                '초청자',
                '관계',
                '전도사',
                '나이',
                '생년월일',
                '국적',
                '이메일',
                '전화번호',
                '학생 알고 있음',
            ];
        }

        return [
            'Nombre Completo',
            'Quien Invitó',
            'Relación',
            'Evangelista Encargada',
            'Edad',
            'Fecha Nacimiento',
            'Nacionalidad',
            'Email',
            'Teléfono',
            'Conoce Estudiantes',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1D4ED8']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 25,
            'C' => 25,
            'D' => 30,
            'E' => 10,
            'F' => 18,
            'G' => 18,
            'H' => 30,
            'I' => 18,
            'J' => 30,
        ];
    }

    public function title(): string
    {
        return $this->promocion->nombre;
    }
}
