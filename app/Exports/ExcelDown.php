<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Spot;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class ExcelDown implements FromView, WithStyles, WithColumnWidths, WithEvents
{
    use Exportable;
    use RegistersEventListeners;
    public function styles(Worksheet $sheet)
    {
        return [
            'A:M' => ['alignment' => ['vertical' => 'center']],
        ];
    }

    public function forYear(int $year)
    {
        $this->year = $year;
        return $this;
    }
    public function view() : View {
        $spot = Spot::get_spot($this->year);
        $report = Spot::get_report($this->year);
        $data = [
            'spot' => $spot,
            'report' => $report,
        ];
        return view('excel', $data);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 28.57,
            'B' => 22.85,
            'C' => 22.85,
            'D' => 14.42,
            'E' => 22.85,
            'F' => 14.42,
            'G' => 22.85,
            'H' => 14.42,
            'I' => 22.85,
            'J' => 14.42,
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A3);
        $sheet->getPageMargins()->setLeft(0.25);
        $sheet->getPageMargins()->setRight(0.25);
        $sheet->getStyle('A3')->getAlignment()->setWrapText(true);
        $sheet->getStyle('B3')->getAlignment()->setWrapText(true);
        $sheet->getStyle('C3')->getAlignment()->setWrapText(true);
        for ($i = 0; $i < 1000; $i++) {
            $sheet->getStyle('G'.($i + 6))->getAlignment()->setWrapText(true);
            $sheet->getStyle('I'.($i + 6))->getAlignment()->setWrapText(true);
        }
    }
}
