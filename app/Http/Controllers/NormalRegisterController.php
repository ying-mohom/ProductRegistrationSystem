<?php

namespace App\Http\Controllers;

use App\Model\Item;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Interfaces\ItemInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\DBTransactions\Item\SaveItem;
use App\Interfaces\CategoryInterface;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\NormalRegisterRequest;
use App\DBTransactions\Category\SaveCategory;
use App\DBTransactions\Category\RemoveCategory;


/**
 * Create Controller to Manage Normal Register Input
 * @author YingMoHom
 * @create 21/06/2023
 */

class NormalRegisterController extends Controller
{


    /**
     * Define Construtor
     * @author YingMoHom
     * @create 22/06/2023
     */
    protected $categoryInterface, $itemInterface;
    public function __construct(CategoryInterface $categoryInterface, ItemInterface $itemInterface)
    {
        $this->categoryInterface = $categoryInterface;
        $this->itemInterface = $itemInterface;
    }

    /**
     * Show Normal Register Form.
     * @author YingMoHom
     * @create 22/06/2023
     */

    public function create()
    {

        $latestId = $this->itemInterface->getLatestId();  //Get Latest ID;
        if (!$latestId) {
            $latestId = 0;
        }
        $itemId = $latestId + 10001;

        $categories = $this->categoryInterface->getAllCategories();
        $itemsCategories = $this->categoryInterface->getItemsCategory();

        return view('register.normalRegister', compact('itemId', 'categories', 'itemsCategories'));
    }

    /**
     * Store a newly created item to storage.
     * @author YingMoHom
     * @create 22/06/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NormalRegisterRequest $request)
    {


        //Check Whether this item id is already exist in database
        if ($this->itemInterface->getItemByItemId($request->itemId)) {

            return redirect()->back()->with('fail', 'This ID is already register by other user');
        }

        //check if a category exists or does not exist in a table
        $hasCagtegory = $this->categoryInterface->getCategory($request->categoryId);

        try {

            //If register item will use having category execute the following process
            if ($hasCagtegory) {

                $save = new SaveItem($request);
                $saveItem = $save->executeProcess();

                //Show Success Message After store data Successfully
                if ($saveItem) {
                    return redirect()->route('items.list')->with('success', 'Your Data store Successfully');
                } else {
                    return redirect()->back()->with('fail', 'Something Wrong!Please Try Again!');
                }
            } else {
                return redirect()->back()->with('fail', 'Category does not exist!Please try again!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($e->getMessage());
        }
    }
    /**
     * Store a newly created category to storage.
     * @author YingMoHom
     * @create 22/06/2023
     * @param  CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function storeCategory(Request $request)
    {
        $saveCategory = new SaveCategory($request);

        $saveCategory = $saveCategory->executeProcess();

        if ($saveCategory) {
            return response()->json([
                'success' => true,

            ]);
        } else {

            return response()->json([
                'success' => false,

            ]);
        }
    }

    /**
     * Remove  category from storage.
     * @author YingMoHom
     * @create 22/06/2023
     * @param  CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function removeCategory(Request $request)
    {
        $removeCategory = new RemoveCategory($request);
        $removeCategory = $removeCategory->executeProcess();

        if ($removeCategory) {

            return response()->json([
                'success' => true,

            ]);
        } else {

            return response()->json([
                'success' => false,

            ]);
        }
    }

    /**
     * Get Latest ID for new added category value
     * @author YingMoHom
     * @create 22/06/2023
     * @return latest Id
     */

    public function getLatestCategoryId()
    {
        $latestCategoryId = $this->categoryInterface->getLatestId();

        // Return the response as JSON
        return response()->json(['latestId' => $latestCategoryId]);
    }
}
