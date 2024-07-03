<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    /**
     * Return a collection of users.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Select only the necessary columns
        return User::select('id', 'name', 'email', 'role', 'created_at', 'updated_at')->get();
    }

    /**
     * Return the headings for the spreadsheet.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            ['Data User'], // Additional title row
            ['ID', 'Name', 'Email', 'Role', 'Created At', 'Updated At'] // Table headers
        ];
    }

    /**
     * Map the user data.
     *
     * @param $user
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->role,
            Carbon::parse($user->created_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'), // Tanggal dibuat dengan zona waktu Asia/Jakarta.
            Carbon::parse($user->updated_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'), // Tanggal diperbarui dengan zona waktu Asia/Jakarta.
        ];
    }

    /**
     * Apply styles to the spreadsheet.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Set font to Times New Roman for entire sheet
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Times New Roman');

        // Style for the headers
        $sheet->getStyle('A2:F2')->applyFromArray([
            'font' => [
                'name' => 'Times New Roman',
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0275D8'], // Dark Blue
            ],
        ]);

        // Border for table headers and data
        $sheet->getStyle('A2:F' . $sheet->getHighestRow())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Center alignment for table headers and data
        $sheet->getStyle('A2:F' . $sheet->getHighestRow())
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        // Font for table data
        $sheet->getStyle('A3:F' . $sheet->getHighestRow())
            ->getFont()
            ->setName('Times New Roman');
    }

    /**
     * Register events to modify the sheet.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Add title "Data User"
                $sheet->setCellValue('A1', 'Data User');
                $sheet->mergeCells('A1:F1');

                // Style for the title
                $sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'name' => 'Times New Roman',
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}
