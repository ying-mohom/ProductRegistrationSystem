<?php

namespace App\DBTransactions\Item;

use App\Model\Item;
use App\Model\ItemsUpload;
use App\Classes\DBTransaction;
use Illuminate\Support\Facades\DB;

/**
 * Update Item From Normal Register Form
 * @author YingMoHom
 * @create 04/07/2023
 *
 */

class UpdateItem extends DBTransaction
{
    /**
     * Define Constructor
     * @author YingMoHom
     * @create 04/07/2023
     *
     */
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Save Item to Database
     * @author YingMoHom
     * @create 04/07/2023
     */
    public function process()
    {
        $request = $this->request;

        //   Request Data for Item Table
        $id = $request->input('id');
        $itemId = $request->input('itemId');
        $itemCode = $request->input('itemCode');
        $itemName = $request->input('itemName');
        $categoryId = $request->input('categoryId');
        $receivedDate = $request->input('receivedDate');
        $safetyStock = $request->input('safetyStock');
        $description = $request->input('description');

        $item = Item::find($id);
        //If there is item by given id execute the following process
        if ($item && $item['deleted_at'] == null) {
            //Check Has File Or Not If has store in database
            if ($request->hasFile('file')) {

                $item->item_id = $itemId;
                $item->item_code = $itemCode;
                $item->item_name = $itemName;
                $item->category_id = $categoryId;
                $item->received_date = $receivedDate;
                $item->safety_stock = $safetyStock;
                $item->description = $description;
                $item->save();


                $file = $request->file('file'); //get file

                $fileName = $itemId . $file->getClientOriginalName(); //getFileName
                $filePath = 'fileUpload' . '/' . $fileName;
                $fileInfo = getimagesize($file);
                $width = $fileInfo[0];
                $height = $fileInfo[1];
                // Calculate the file size in bytes
                $fileSizeBytes = $width * $height;

                // Get the MIME type from the array
                $mimeType = $fileInfo['mime'];

                // Extract the file extension from the MIME type
                $fileExtension = explode('/', $mimeType)[1];

                $file = ItemsUpload::where('item_id', $itemId)->first();

                //Update Existing file
                if ($file) {
                    
                    //Remove from public path
                    if (file_exists(public_path($file->file_path))) {
                        unlink(public_path($file->file_path));
                    }

                    $file->file_path = $filePath;
                    $file->file_type = $fileExtension;
                    $file->file_size = $fileSizeBytes;
                    $file->item_id = $itemId;
                    $file->save();

                    //Store File in public path
                    $fileSave = $request->file('file')->move(public_path('fileUpload'), $fileName);
                } else {
                     //If there is photo update new photo
                     $newFile = new ItemsUpload();
                     $newFile->file_path = $filePath;
                     $newFile->file_type = $fileExtension;
                     $newFile->file_size = $fileSizeBytes;
                     $newFile->item_id = $itemId;
                     $newFile->save();
 
                     //Store File in public path
                     $fileSave = $request->file('file')->move(public_path('fileUpload'), $fileName);
                }
            }
      
            $item->item_id = $itemId;
            $item->item_code = $itemCode;
            $item->item_name = $itemName;
            $item->category_id = $categoryId;
            $item->received_date = $receivedDate;
            $item->safety_stock = $safetyStock;

            $item->description = $description;

            $item->save();

            return ['status' => true, 'error' => ''];
        } else { //If no item by given by id return false

            return ['status' => false, 'error' => 'Failed!'];
        }
    }
}
