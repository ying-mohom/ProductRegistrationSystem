<?php

namespace App\DBTransactions\Category;

use App\Classes\DBTransaction;
use App\Model\Category;
use Illuminate\Support\Facades\Log;

/**
 * Create Class For Save Category to database
 * @author YingMoHom
 * @create 28/06/2023
 * 
 */
class SaveCategory extends DBTransaction
{
    /**
     * Define Constructor
     * @author YingMoHom
     * @create 28/06/2023
     * 
     */
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Save Category to Database
     * @author YingMoHom
     * @create 28/06/2023 
     */

    public function process()
    {


        $request = $this->request;
        $categoryName = $request->input('categoryName');
        $category = new Category();

        $category->category_name = $categoryName;
        $category->save();
        
       //Check If category exist or not
        if (!$category) {
            return ['status' => false, 'error' => 'Failed!'];
        }
        return ['status' => true, 'error' => ''];
    }
}
