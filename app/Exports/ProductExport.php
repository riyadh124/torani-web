<?php
namespace App\Exports;

use App\Models\InventoryItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnWidths
{
    /**
     * Retrieve the data for the export
     */
    public function collection()
    {
        return InventoryItem::all()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category,
                'stock_quantity' => $product->stock_quantity,
                'unit' => $product->unit,
                'unit_price' => $product->unit_price,
                'thumbnail' => $product->thumbnail,
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
            'Product Name',
            'Category',
            'Stock Quantity',
            'Unit',
            'Unit Price',
            'Thumbnail',
        ];
    }

    /**
     * Apply styles to the worksheet.
     */
    public function styles(Worksheet $sheet)
    {
        // Apply bold font to the header row (row 1)
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        // Center align the text in the header row
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center');
        
        // Apply background color to the header row
        $sheet->getStyle('A1:G1')->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()->setARGB('FFDDDDDD');

        // Apply borders to all cells
        $sheet->getStyle('A1:G' . $sheet->getHighestRow())->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    }

    /**
     * Set custom column widths.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 10,  // ID column width
            'B' => 25,  // Product Name column width
            'C' => 20,  // Category column width
            'D' => 15,  // Stock Quantity column width
            'E' => 10,  // Unit column width
            'F' => 15,  // Unit Price column width
            'G' => 30,  // Thumbnail column width
        ];
    }
}
