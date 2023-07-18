<?php

namespace App\DBTransactions\Item;

use App\Model\Item;
use App\Model\ItemsUpload;
use App\Classes\DBTransaction;
use Illuminate\Support\Facades\Log;


/**
 * Delete Item From List
 * @author YingMoHom
 * @create 03/07/2023
 * 
 */

class DeleteItem extends DBTransaction
{
    /**
     * Define Constructor
     * @author YingMoHom
     * @create 03/07/2023
     * 
     */
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Delete Item From Database
     * @author YingMoHom
     * @create 03/07/2023 
     */
    public function process()
    {
        $request = $this->request;

        $id = $request->input('item_id');

        $item = Item::find($id); //Find Item By Id

        if ($item && $item['deleted_at'] == null) {

            $itemId = $item->item_id; //Get Item Id from item table

            $image = ItemsUpload::where('item_id', $itemId)->first(); //Find by item id in Item Upload Table

            //Delete item from both tables if tables have item id
            if ($image) {

                $filePath = $image->file_path;

                // Delete the photo file from folder  using unlink
                if (file_exists(public_path($filePath))) {
                    unlink(public_path($filePath));
                }

                $image->delete();

                $deleteItem = Item::find($id)->delete();
                return ['status' => true, 'error' => ''];
            } else {
                //Delete item from item table
                $deleteItem = Item::find($id)->delete();
                return ['status' => true, 'error' => ''];
            }
        } else {
            // return $deleteItem;
            return ['status' => false, 'error' => 'Failed!'];
        }


        // if (!$deleteItem) {

        //     return ['status' => false, 'error' => 'Failed!'];
        // }
        // return ['status' => true, 'error' => ''];
    }
}
