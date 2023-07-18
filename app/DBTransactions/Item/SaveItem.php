<?php

namespace App\DBTransactions\Item;

use App\Model\Item;
use App\Model\ItemsUpload;
use App\Classes\DBTransaction;
use Illuminate\Support\Facades\DB;

/**
 * Save Item From Normal Register Form
 * @author YingMoHom
 * @create 22/06/2023
 * 
 */

class SaveItem extends DBTransaction
{
    /**
     * Define Constructor
     * @author YingMoHom
     * @create 22/06/2023
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
     * @create 22/06/2023 
     */
    public function process()
    {
        $request = $this->request;

        //   Request Data for Item Table
        $itemId = $request->input('itemId');
        $itemCode = $request->input('itemCode');
        $itemName = $request->input('itemName');
        $categoryId = $request->input('categoryId');
        $receivedDate = $request->input('receivedDate');
        $safetyStock = $request->input('safetyStock');
        $description = $request->input('description');

        // Request Data for Saving File
        $item = new Item();
        $item->item_id = $itemId;
        $item->item_code = $itemCode;
        $item->item_name = $itemName;
        $item->category_id = $categoryId;
        $item->received_date = $receivedDate;
        $item->safety_stock = $safetyStock;
        $item->description = $description;
        $item->save();

        //Check Has File Or Not If has store in database
        if ($request->hasFile('file')) {
            
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


            $file = new ItemsUpload();
            $file->file_path = $filePath;
            $file->file_type = $fileExtension;
            $file->file_size = $fileSizeBytes;
            $file->item_id = $itemId;
            $file->save();

            //Store File in public path
            $fileSave = $request->file('file')->move(public_path('fileUpload'), $fileName);
        }

        if (!$item) {
            return ['status' => false, 'error' => 'Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}
