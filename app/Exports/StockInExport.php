<?php
namespace App\Exports;

use App\Models\StockIn;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class StockInExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnWidths
{
    /**
     * Export stock-in data with related inventory items.
     */
    public function collection()
    {
        return StockIn::with('inventoryItems')->get()->map(function ($stockIn) {
            return [
                'id' => $stockIn->id,
                'date' => $stockIn->created_at->format('Y-m-d'),
                'notes' => $stockIn->notes,
                'items' => $stockIn->inventoryItems->map(function ($item) {
                    return "{$item->name} ({$item->pivot->quantity} {$item->unit})";
                })->implode(', '),
            ];
        });
    }

    /**
     * Define the headings for the exported Excel file.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Date',
            'Notes',
            'Items',
        ];
    }

    /**
     * Apply styles to the worksheet.
     */
    public function styles(Worksheet $sheet)
    {
        // Apply bold font to the header row (row 1)
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        // Center align the text in the header row
        $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal('center');
        
        // Apply background color to the header row
        $sheet->getStyle('A1:D1')->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()->setARGB('FFDDDDDD');

        // Apply borders to all cells
        $sheet->getStyle('A1:D' . $sheet->getHighestRow())->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }

    /**
     * Set custom column widths.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 10,  // ID column width
            'B' => 15,  // Date column width
            'C' => 30,  // Notes column width
            'D' => 50,  // Items column width
        ];
    }
}
