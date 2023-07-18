<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Create DownloadItemsExport
 * @author YingMoHom
 * @create 03/07/2023
 */
class DownloadItemsExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    use Exportable;

    /**
     * Define Constructor for DownloadItemsExport
     * @author YingMoHom
     * @create 03/07/2023
     */

    protected $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * Data form item table to export
     * @author YingMoHom
     * @create 03/07/2023
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $number = 1;
        return $this->items->map(function ($item) use (&$number) {
            
            return [
                'number' => $number++,
                'item_id' => $item->item_id,
                'item_code' => $item->item_code,
                'item_name' => $item->item_name,
                'category_name' => $item->category_name,
                'safety_stock'  => $item->safety_stock,
                'received date' => $item->received_date,
                'description'  => $item->description,
            ];
        });
    }

    /**
     * Header for DownloadItemsExport
     * @author YingMoHom
     * @create 03/07/2023
     */

    public function headings(): array
    {
        return [

            [
                'No',
                'Item ID',
                'Item Code',
                'Item Name',
                'Category Name',
                'Safety Stock',
                'Received Date',
                'Description'

            ]
        ];
    }
    /**
     *  Title for Sheet
     * @author YingMoHom
     * @create 23/06/2023
     */

    public function title(): string
    {
        // Adding title for Item Registration Sheet
        return 'ItemsList';
    }

    /**
     * Styles for DownloadItemsExport
     * @author YingMoHom
     * @create 03/07/2023
     */
    public function styles(Worksheet $sheet)
    {
        // Style the headers
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF', 
                ],
                'size' => 13,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],


        ]);
        // Set cell background color
        $sheet->getStyle('A1:H1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('037171');

        // Set alignment to wrap text
        $sheet->getStyle('A2:H' . ($this->items->count() + 1))->getAlignment()->setWrapText(true);



        $lastRow = $sheet->getHighestRow();
        $range = 'A2:H' . $lastRow;
        
        //Set Vertical Top For All Cells
        $sheet->getStyle($range)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);





        $sheet->getColumnDimension('A')->setWidth(20); // Set width for column A to 20
        $sheet->getColumnDimension('B')->setWidth(20); // Set width for column B to 20
        $sheet->getColumnDimension('C')->setWidth(20); // Set width for column C to 20
        $sheet->getColumnDimension('D')->setWidth(20); // Set width for column D to 20
        $sheet->getColumnDimension('E')->setWidth(35); // Set width for column E to 20
        $sheet->getColumnDimension('F')->setWidth(20); // Set width for column F to 20
        $sheet->getColumnDimension('G')->setWidth(20); // Set width for column F to 20
        $sheet->getColumnDimension('H')->setWidth(80); // Set width for column F to 20

        // Set row height for row 1
        $sheet->getRowDimension(1)->setRowHeight(30); // Set height for the first row to 30
        
    }
}
