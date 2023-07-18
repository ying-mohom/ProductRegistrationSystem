<?php

namespace App\Exports;

use App\Item;
use App\Model\Category;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Multiple Sheet Excel Export
 * @author YingMoHom
 * @create 23/06/2023
 */
class ExcelExport implements WithMultipleSheets
{


    /**
     * @param Collection $collection
     */

    public function sheets(): array
    {
        $sheet = [
            new ItemRegistrationSheet,
            new CategorySheet,

        ];
        return $sheet;
    }
}

/**
 * ItemRegistrationSheet
 * @author YingMoHom
 * @create 23/06/2023
 */
class ItemRegistrationSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{

    /**
     * Data from Item table
     * @author YingMoHom
     * @create 23/06/2023
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = [
            [
                'Item Code' => null,
                'Item Name' => null,
                'Category Name' => null,
                'Safety Stock' => null,
                'Received Date' => null,
                'Description' => null,
            ],
        ];

        return collect($data);
    }

    /**
     * Header for ItemsRegistration Sheet
     * @author YingMoHom
     * @create 23/06/2023
     */

    public function headings(): array
    {
        return [
            ['* Do not allow the file that the number of rows are greater than 100 rows. '],
            ['* Please look at the Category Name Sheet and enter that id in the Category Name ID column '],
            [
                'Item Code',
                'Item Name',
                'Category Name',
                'Safety Stock',
                'Received Date',
                'Description',
            ]
        ];
    }
    /**
     *  Title for Item Registration Sheet
     * @author YingMoHom
     * @create 23/06/2023
     */

    public function title(): string
    {
        // Adding title for Item Registration Sheet
        return 'Item Registration';
    }

    /**
     *  Style for Item Registration Sheet
     * @author YingMoHom
     * @create 23/06/2023
     */
    
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');




        // Style the headers
        $sheet->getStyle('A1:E2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'FF0000',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],


        ]);
        // Set the text color to red in the range A3 to E3
        $style = $sheet->getStyle('A3:E3');
        $style->getFont()->getColor()->setRGB(Color::COLOR_RED);



        $lastRow = $sheet->getHighestRow();
        $range = 'A3:F' . $lastRow;
        // Set cell background color
        $sheet->getStyle('A3:F3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('87CEEB');

        // Apply borders to the range A3:F3
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('A3:F3')->applyFromArray($borderStyle);

        //Apply Font Bold to A3:F3
        $fontBold = [
            'font' => [
                'bold' => true
            ]
        ];
        $sheet->getStyle('A3:F3')->applyFromArray($fontBold);



        $sheet->getColumnDimension('A')->setWidth(20); // Set width for column A to 20
        $sheet->getColumnDimension('B')->setWidth(20); // Set width for column B to 20
        $sheet->getColumnDimension('C')->setWidth(20); // Set width for column C to 20
        $sheet->getColumnDimension('D')->setWidth(20); // Set width for column D to 20
        $sheet->getColumnDimension('E')->setWidth(20); // Set width for column E to 20
        $sheet->getColumnDimension('F')->setWidth(20); // Set width for column F to 20

        // Set row height
        $sheet->getRowDimension(1)->setRowHeight(30); // Set height for the first row to 30
        $sheet->getRowDimension(2)->setRowHeight(30); // Set height for the second row to 30
        $sheet->getRowDimension(3)->setRowHeight(30); // Set height for the third row to 30

        // Set text alignment to center for all cells
        $sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // Set vertical alignment to center for all cells
        $sheet->getStyle($range)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }
}
/**
 * Category Sheet
 * @author YingMoHom
 * @create 23/06/2023
 */
class CategorySheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    /**
     * Data from category table
     * @author YingMoHom
     * @create 23/06/2023
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {  //Get all items
        $items = Category::select('id', 'category_name')->orderBy('id')->get();

        return $items;
    }

    /**
     * Header for Category Sheet
     * @author YingMoHom
     * @create 23/06/2023
     */

    public function headings(): array
    {
        //header for category sheet
        return [
            ['Category List'],
            ['ID', 'Category Name',]
        ];
    }

    /**
     * Title for Category Sheet
     * @author YingMoHom
     * @create 23/06/2023
     */

    public function title(): string
    {
        // Adding title Category Sheet
        return 'Category';
    }

    /**
     * Styles for Category Sheet
     * @author YingMoHom
     * @create 23/06/2023
     */

    public function styles(Worksheet $sheet)
    {
        // Style the headers for Category Sheet
        $sheet->getStyle('A1:B2')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '87CEEB',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $lastRow = $sheet->getHighestRow();
        $range = 'A2:F' . $lastRow;
        $sheet->mergeCells('A1:B1'); //mergeCells from A1 to B1


        // Set cell borders
        $sheet->getStyle('A2:B2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $sheet->getColumnDimension('A')->setWidth(20); // Set width for column A to 20
        $sheet->getColumnDimension('B')->setWidth(35); // Set width for column B to 20
       
        // Set row height
        $sheet->getRowDimension(1)->setRowHeight(30); // Set height for the first row to 30
        $sheet->getRowDimension(2)->setRowHeight(20); // Set height for the second row to 20
        // Set horizontal alignment to center for all cells
        $sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // Set vertical alignment to center for all cells
        $sheet->getStyle($range)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        // Set font size for all cells
        $sheet->getStyle('A1:B1')->getFont()->setSize(12);
    }
}
