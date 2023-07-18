<?php

namespace App\DBTransactions\ItemUpload;

use App\Model\Item;
use App\Model\ItemsUpload;
use App\Classes\DBTransaction;
use Illuminate\Support\Facades\Log;


/**
 * Delete Image From Database
 * @author YingMoHom
 * @create 04/07/2023
 * 
 */

class DeleteImage extends DBTransaction
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
     * Delete Image From Database
     * @author YingMoHom
     * @create 04/07/2023 
     */
    public function process()
    {
        $request = $this->request;

        $fileName = $request->input('fileName');
        $filePath = 'fileUpload'.'/'.$fileName;

        

        $deleteImage = ItemsUpload::where('file_path','=',$filePath)->delete(); //Find image by file path and delete it
        
        //Remove Image from pulic folder
        if (file_exists(public_path($filePath))) {
            unlink(public_path($filePath));
        }

        
        if (!$deleteImage) {

            return ['status' => false, 'error' => 'Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}
