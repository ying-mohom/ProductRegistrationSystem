<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use PgSql\Lob;
use App\Model\Item;
use Illuminate\Http\Request;
use App\Interfaces\ItemInterface;
use Illuminate\Support\Facades\Log;
use App\Exports\downloadItemsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Interfaces\CategoryInterface;
use Illuminate\Support\Facades\Route;
use App\DBTransactions\Item\DeleteItem;
use App\DBTransactions\Item\UpdateItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\NormalRegisterRequest;
use App\DBTransactions\ItemUpload\DeleteImage;

/**
 * Create Controller to Manage List Action
 * @author YingMoHom
 * @create 21/06/2023
 */

class ItemController extends Controller
{

    /**
     * Define Constructor
     * @author YingMoHom
     * @create 21/06/2023
     */
    protected  $itemInterface, $categoryInterface;

    public function __construct(ItemInterface $itemInterface, CategoryInterface $categoryInterface)
    {
        $this->itemInterface = $itemInterface;
        $this->categoryInterface = $categoryInterface;
    }
    /**
     * Show Item List according to data in database
     * @author YingMoHom
     * @create 27/06/2023
     */
    public function index()
    {
        $items = $this->itemInterface->getAllItems();
        $rowCount = $items->total();
        $itemCount = count($items);

        $categories = $this->categoryInterface->getAllCategories();
        return view('itemsList', compact('items', 'categories', 'itemCount', 'rowCount'));
    }

    /**
     * Display the item detail
     * @author YingMoHom
     * @create 04/07/2023
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = $this->categoryInterface->getAllCategories();
        $itemsCategories = $this->categoryInterface->getItemsCategory();
        $item = $this->itemInterface->getDataForDetail($id);


        //If item is exist excute the following process
        if ($item) {

            // Check if the item has a file_path
            if (isset($item->file_path) && $item->file_path !== '') {
                $filePath = $item->file_path;
                $fileName = basename($filePath);
            } else {
                $fileName = null;
            }
            return view('itemsDetail', compact('item', 'categories', 'itemsCategories', 'fileName'));
        } else {
            //If item is deleted in another tab and want to delete it show this error message
            return redirect()->back()->with("error", "Oops! Something went wrong or the item you are trying to process does not exist.");
        }
    }

    /**
     * Show the form for editing item 
     * @author YingMoHom
     * @create 04/07/2023
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $categories = $this->categoryInterface->getAllCategories();
        $itemsCategories = $this->categoryInterface->getItemsCategory();
        $item = $this->itemInterface->getItemDataById($id);


        $url = url()->previous();
        $routeName = '';

        if ($url) {

            $route = Route::getRoutes()->match(Request::create($url));
            $routeName = $route ? $route->getName() : '';
        }


        //If item exists excute the following process
        if ($item) {
            // Check if the item has a file_path
            if (isset($item->file_path) && $item->file_path !== '') {
                $filePath = $item->file_path;
                $fileName = basename($filePath);
            } else {
                $fileName = null;
            }

            return view('itemsEdit', compact('item', 'categories', 'itemsCategories', 'fileName'));
        } else {
        
            if ($routeName == "item.edit") {

                if (Session::get('requestReferrer')) {
                    
                    return redirect(Session::get('requestReferrer'))->with("error", "Oops! Something went wrong or the item you are trying to process does not exist.");
                }               
                return redirect()->back()->with("error", "Oops! Something went wrong or the item you are trying to process does not exist.");
            }
          
            //If item is deleted in another tab and want to access it show this error message
            return redirect()->back()->with("error", "Oops! Something went wrong or the item you are trying to process does not exist.");
        }
    }

    /**
     * Update item to database
     * @author YingMoHom
     * @create 04/07/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(NormalRegisterRequest $request)
    {
        $update = new UpdateItem($request);
        $updateItem = $update->executeProcess();

        //Show Error Message
        if (!$updateItem) {
            
            return redirect(Session::get('requestReferrer'))->with('error', 'Oops! Something went wrong or the item you are trying to process does not exist.');
           
        }
        //Upate Show success message
        return redirect(Session::get('requestReferrer'))->with('success', 'Your Item Edit Successfully');
        
    }

    /**
     * Remove item from item table
     * @author YingMoHom
     * @create 03/07/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {

        $delete = new DeleteItem($request);
        $deleteItem = $delete->executeProcess();


        if ($deleteItem) {
            session()->flash('success', "Your Item is Deleted Successfully!");
            return response()->json([
                'success' => true,

            ]);
        } else {
            session()->flash('error', "Oops! Something went wrong or the item you are trying to process does not exist.");
            return response()->json([
                'success' => false,

            ]);
        }
    }

    /**
     * Search Item according to giving Value and Download 
     * @author YingMoHom
     * @create 30/06/2023
     * @update 03/07/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {

        $itemId = $request->input('itemId');
        $itemCode = $request->input('itemCode');
        $itemName = $request->input('itemName');
        $category = $request->input('category');
        $type = $request->input('search');

        //Search Data According to Input Field
        if ($type == 'search') {

            $items = $this->itemInterface->getSearchItems($request);

            $categories = $this->categoryInterface->getAllCategories();

            $rowCount = $items->total();
            $itemCount = count($items);

            //Check there is no input field show all data
            if ($itemId == "" && $itemCode == "" && $itemName == "" && $category == "") {
                return redirect()->route('items.list');
            }
            return view('itemsList', compact('items', 'categories', 'itemCount', 'rowCount'));
        }

        //Create PDF download
        if ($type == 'pdf') {

            return Redirect::route('items.pdfDownload', [

                'itemId' => $itemId,
                'itemCode' => $itemCode,
                'itemName' => $itemName,
                'category' => $category,
                'type'     => $type,
            ]);
        }


        //Create Excel Download
        if ($type == 'excel') {

            return Redirect::route('items.excelDownload', [

                'itemId' => $itemId,
                'itemCode' => $itemCode,
                'itemName' => $itemName,
                'category' => $category,
                'type'     => $type,

            ]);
        }
    }

    /**
     * Change Active to Inactive and set date to deleted_at 
     * @author YingMoHom
     * @create 27/06/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function updateActiveStatus(Request $request)
    {
        $itemId = $request->input('item_id');


        // Get the item record from the database
        $item = $this->itemInterface->getItemById($itemId);

        //if find by $itemId has record then set deleted_at to current date time
        if ($item) {

            if ($item->deleted_at == null) {
                // Set the deleted_at field to the current date and time
                $item->deleted_at = now();
                $item->save();

                session()->flash('success', "Item Inactive Successfully!");
                return response()->json([
                    'success' => true,

                ]);
            } else {
                session()->flash('error', "Item is already Inactive");
                return response()->json([
                    'success' => false,

                ]);
            }
        } else {
            session()->flash('error', "Oops! Something went wrong or the item you are trying to process does not exist.");
            return response()->json([
                'success' => false,

            ]);
        }
    }

    /**
     * Change Inactive to Active and set null to deleted_at 
     * @author YingMoHom
     * @create 27/06/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateInactiveStatus(Request $request)
    {
        $itemId = $request->input('item_id');

        // Get the item record from the database
        $item = $this->itemInterface->getItemById($itemId);

        //if find by $itemId has record then set deleted_at to null
        if ($item) {

            if (!$item->deleted_at == null) {

                $item->deleted_at = null; // Restore deleted_at to null
                $item->save();

                session()->flash('success', "Item Active Successfully!");
                return response()->json([
                    'success' => true,

                ]);
            } else {
                session()->flash('error', "Item is already Active");
                return response()->json([
                    'success' => false,

                ]);
            }
        } else {
            session()->flash('error', "Oops! Something went wrong or the item you are trying to process does not exist.");
            return response()->json([
                'success' => false,

            ]);
        }
    }

    /**
     * Fetch Item Name and Item Code According to given Item Id
     * @author YingMoHom
     * @create 30/06/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function fetch(Request $request)
    {
        $itemId = $request->input('item_id');
        $item = $this->itemInterface->getItemByItemId($itemId);

        //If there is item find by id then set item name and item code and pass to ajax function
        if ($item) {
            return response()->json([
                'success' => true,
                'data' => [
                    'item_name' => $item->item_name,
                    'item_code' => $item->item_code,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => null,
            ]);
        }
    }

    /**
     * Remove image form database when user click remove button
     * @author YingMoHom
     * @create 04/07/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function deleteImage(Request $request)
    {

        $delete = new DeleteImage($request);

        $deleteImage = $delete->executeProcess();


        if ($deleteImage) {
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
     * Download Items in PDF 
     * @author YingMoHom
     * @create 05/06/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function pdfDownload(Request $request)
    {
        // Retrieve the search parameters from the request
        $itemId = $request->input('itemId');
        $itemCode = $request->input('itemCode');
        $itemName = $request->input('itemName');
        $category = $request->input('category');



        if ($itemId == "" && $itemCode == "" && $itemName == "" && $category == "") {

            $items = $this->itemInterface->getAllItemsForDownLoad();
        } else {
            $items = $this->itemInterface->getSearchItems($request);
        }

        // Create the mPDF document
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'L', // Set orientation to landscape
        ]);

        // Setup a filename 
        $pdfFileName = "Item.pdf";

        // Pass the $items variable to the view and generate the PDF content
        $pdf->WriteHTML(view('pdfDownload')->with('items', $items)->render());

        // Output the PDF for download
        $pdf->Output($pdfFileName, 'D');
    }

    /**
     * Download Items in Excel 
     * @author YingMoHom
     * @create 05/06/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function excelDownload(Request $request)
    {
        // Retrieve the search parameters from the request
        $itemId = $request->input('itemId');
        $itemCode = $request->input('itemCode');
        $itemName = $request->input('itemName');
        $category = $request->input('category');


        if ($itemId == "" && $itemCode == "" && $itemName == "" && $category == "") {

            $items = $this->itemInterface->getAllItemsForDownLoad();
        } else {
            $items = $this->itemInterface->getSearchItems($request);
        }
        return Excel::download(new DownloadItemsExport($items), 'itemsList.xlsx');
    }

    /**
     * Make autocomplete for item id
     * @author YingMoHom
     * @create 12/07/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function autocompleteItemId(Request $request)
    {
        $term = $request->get('term');
        $items = $this->itemInterface->autocompleteItemId($term);
        return response()->json($items);
    }
    /**
     * Make autocomplete for item id
     * @author YingMoHom
     * @create 12/07/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function autocompleteItemCode(Request $request)
    {
        $term = $request->get('term');
        $items = $this->itemInterface->autocompleteItemCode($term);
        return response()->json($items);
    }
    /**
     * Make autocomplete for item id 
     * @author YingMoHom
     * @create 12/07/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function autocompleteItemName(Request $request)
    {
        $term = $request->get('term');
        $items = $this->itemInterface->autocompleteItemName($term);
        return response()->json($items);
    }
}
