<?php

namespace App\Repositories;

use App\Model\Item;
use App\Model\Category;
use App\Model\ItemsUpload;
use App\Interfaces\ItemInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 *Repository for Item
 * @author YingMoHom
 * @create 22/06/2023 
 * 
 */
class ItemRepository implements ItemInterface
{

    /**
     * Get Items From storage.
     * @author YingMoHom
     * @create 22/06/2023
     * @return array
     */

    public function getAllItems()
    {
        $items = DB::table('items')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->select(
                'items.*',
                'categories.category_name'
            )
            ->orderByDesc('items.created_at')
            ->paginate(10);

        return $items;
    }

    /**
     * Get  Latest Id From Item Table.
     * @author YingMoHom
     * @create 22/06/2023
     * @return latest Id
     */

    public function getLatestId()
    {
        $latestId = Item::latest('id')->value('id');
        return $latestId;
    }

    /**
     * Get Items According to given  id.
     * @author YingMoHom
     * @create 03/07/2023
     * @param $id
     * @return item search by  id
     */
    public function getItemById($id)
    {
        $item  = Item::find($id);
        return $item;
    }

    /**
     * Get Items According to given item id.
     * @author YingMoHom
     * @create 30/06/2023
     * @param $itemId
     * @return item search by item id
     */
    public function getItemByItemId($itemId)
    {
        $item  = Item::where('item_id', $itemId)->first();
        return $item;
    }

    /**
     * Get Items According to search data.
     * @author YingMoHom
     * @create 30/06/2023
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    public function getSearchItems($request)
    {
        $itemId   = $request->input('itemId');
        $itemCode = $request->input('itemCode');
        $itemName = $request->input('itemName');
        $category = $request->input('category');
        $type     = $request->input('type');

        $query = DB::table('items')
            ->join('categories', 'categories.id', '=', 'items.category_id')
            ->select('items.*', 'categories.category_name')
            ->orderBy('items.created_at', 'desc')
            ->when($itemId, function ($query, $itemId) {
                return $query->where('items.item_id', 'LIKE', '%' . $itemId . '%');
            })
            ->when($itemCode, function ($query, $itemCode) {
                return $query->where('items.item_code', 'LIKE', '%' . $itemCode . '%');
            })
            ->when($itemName, function ($query, $itemName) {
                return $query->where('items.item_name', 'LIKE', '%' . $itemName . '%');
            })
            ->when($category, function ($query, $category) {
                return $query->where('items.category_id', '=', $category);
            });

        if ($type == 'pdf' ||  $type == 'excel') {
            $items = $query->get();
            return $items;
        } else {

            $items = $query->paginate(10)->appends(request()->except('page'));
            return $items;
        }
    }

    /**
     * Get All Items for download
     * @author YingMoHom
     * @create 03/07/2023
     * @return array
     */

    public function getAllItemsForDownLoad()
    {
        $query = DB::table('items')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->select('items.*', 'categories.category_name')
            ->orderByDesc('items.created_at');
        $items = $query->get();
        return $items;
    }
    /**
     * Get All Items , Category and Photo  for update form 
     * @author YingMoHom
     * @create 03/07/2023
     * @return array
     */
    public function getItemDataById($id)
    {

        // Find Item by Id
        $item = Item::find($id);

        //If Have Item execute the following process
        if ($item && $item['deleted_at'] == null) {
            // Check whether this item has an image
            $hasImage = ItemsUpload::where('item_id', $item->item_id)->exists();

            // Fetch item data 
            $data = DB::table('items')
                ->join('categories', 'items.category_id', '=', 'categories.id')
                ->select('items.*', 'categories.category_name');

            // If there is an image, Fetch item data and image path
            if ($hasImage) {
                $data = DB::table('items')
                    ->join('categories', 'items.category_id', '=', 'categories.id')
                    ->join('items_uploads', 'items.item_id', '=', 'items_uploads.item_id')
                    ->select('items.*', 'categories.category_name', 'items_uploads.file_path');
            }

            $data = $data->where('items.id', '=', $id)
                ->first();

            return $data;
        } else { // If items do not have according to given id return null

            $item = null;
            return  $item;
        }
    }

    /**
     * Get All Items , Category and Photo For Detail Form
     * @author YingMoHom
     * @create 06/07/2023
     * @return array
     */
    public function getDataForDetail($id)
    {

        // Find Item by Id
        $item = Item::find($id);



        //If Have Item execute the following process
        if ($item) {
            // Check whether this item has an image
            $hasImage = ItemsUpload::where('item_id', $item->item_id)->exists();

            // Fetch item data
            $data = DB::table('items')
                ->join('categories', 'items.category_id', '=', 'categories.id')
                ->select('items.*', 'categories.category_name');

            // If there is an image, Fetch item data and image path
            if ($hasImage) {
                $data = DB::table('items')
                    ->join('categories', 'items.category_id', '=', 'categories.id')
                    ->join('items_uploads', 'items.item_id', '=', 'items_uploads.item_id')
                    ->select('items.*', 'categories.category_name', 'items_uploads.file_path');
            }

            $data = $data->where('items.id', '=', $id)
                ->first();

            return $data;
        } else {

            // If items do not have according to given id return null
            $item = null;
            return  $item;
        }
    }

    /**
     *  Make autocomplete for item id
     * @author YingMoHom
     * @create 12/07/2023
     * @return array
     */

    public function autocompleteItemId($itemId)
    {
        $itemId = intval($itemId);
        $items = Item::where('item_id', 'LIKE', '%' . $itemId . '%')->pluck('item_id')->toArray();
        $items = array_map('strval', $items);

        return $items;
    }
    /**
     * Make autocomplete for item code
     * @author YingMoHom
     * @create 12/07/2023
     * @return array
     */

    public function autocompleteItemCode($itemCode)
    {
        $items = Item::where('item_code', 'LIKE', '%' . $itemCode . '%')->pluck('item_code');
        return $items;
    }

    /**
     * Make autocomplete for item name
     * @author YingMoHom
     * @create 12/07/2023
     * @return array
     */

    public function autocompleteItemName($itemName)
    {
        $items = Item::where('item_name', 'LIKE', '%' . $itemName . '%')->pluck('item_name');
        return $items;
    }
}
