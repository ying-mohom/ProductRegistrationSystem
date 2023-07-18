<?php

namespace App\Imports;


use DateTime;
use Carbon\Carbon;
use App\Model\Item;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Excel Import
 * @author YingMoHom
 * @create 26/06/2023
 */
class ExcelImport implements WithMultipleSheets
{
    /**
     * @param Collection $collection
     */
    public function sheets(): array
    {
        return [
            new ItemRegistrationSheetImport()
        ];
    }
}
/**
 * Import ItemRegistrationSheet
 * @author YingMoHom
 * @create 26/06/2023
 */
class ItemRegistrationSheetImport  implements ToCollection
{
    /**
     * Validation Import Data and Store to Database
     * @author YingMoHom
     * @create 27/06/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function collection(Collection $rows)
    {

        $dataRows = $rows->slice(3); // Exclude the first three rows

        //Check records
        if ($dataRows->isEmpty()) {
            throw new \Exception("No records found!");
        }
        //Check Records Within 100 and if not show error message
        if ($dataRows->count() > 100) {
            throw new \Exception("Your Excel File exceeded the maximum limit of 100 rows!");
        }

        $validatedData = [];
        $errors = [];

        //Validate Input Data
        foreach ($dataRows as $rowIndex => $row) {

            $validator = Validator::make($row->toArray(), [
                '0' => 'required',
                '1' => 'required',
                '2' => 'required|exists:categories,id|integer',
                '3' => 'required|integer',
                '4' => 'required|numeric'


            ]);
            //Set Custom Message to cell columns
            $customMessages = [
                '0.required' => 'Item Code is required!',
                '1.required' => 'Item Name is required!',
                '2.required' => 'Category Name is required!',
                '2.exists' => 'The selected Category Id is invalid!',
                '2.integer' => 'The Category Id must be an integer',
                '3.required' => 'The Safety Stock is required!',
                '3.integer' => 'The Safety Stock must be integer!',
                '4.required' => 'Received Date is required!',
                '4.numeric' => 'Received Date field does not allow character!',

            ];

            $validator->setCustomMessages($customMessages);

            //Check Validation if fails put error message in array
            if ($validator->fails()) {
                $columnErrors = $validator->errors()->all();
                $rowErrorMessage = "Row " . ($rowIndex + 1) . ": " . implode(", ", $columnErrors);
                $errors[] = $rowErrorMessage;
            } else {
                // Validated data for a row
                $validatedData[] = [
                    'item_code' => $row[0],
                    'item_name' => $row[1],
                    'category_id' => (int)$row[2],
                    'safety_stock' => (int)$row[3],
                    'received_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4])->format('Y-m-d'),
                    'description' => $row[5],
                ];
            }
        }

        //If has error throw error message

        if (!empty($errors)) {
            //Convert Errors Array to String
            $errorString = implode(',', $errors);
            throw new \Exception($errorString);
        }

        //Store Validated data to database
        foreach ($validatedData as $data) {
            // Get Latest Id from the database
            $latestId = Item::latest('id')->value('id');
            $itemId = $latestId ? $latestId + 10001 : 10001;

            $newItem = new Item();
            $newItem->item_id = $itemId;
            $newItem->item_code = $data['item_code'];
            $newItem->item_name = $data['item_name'];
            $newItem->category_id = $data['category_id'];
            $newItem->safety_stock = $data['safety_stock'];
            $newItem->received_date = $data['received_date'];
            $newItem->description = $data['description'];

            $newItem->save();
        }
    }
}
