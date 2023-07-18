<?php

namespace App\Repositories;

use App\Model\Category;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CategoryInterface;
use Illuminate\Support\Facades\Log;

/**
 *Repository for Category
 * @author YingMoHom
 * @create 22/06/2023 
 * 
 */
class CategoryRepository implements CategoryInterface
{
    /**
     * Get categories from storage.
     * @author YingMoHom
     * @create 22/06/2023
     * @return array
     */
    public function getAllCategories()
    {
        return Category::all();
    }

    /**
     * Get Latest Id from category table.
     * @author YingMoHom
     * @create 22/06/2023
     * @return latest Id
     */

    public function getLatestId()
    {
        $latestCategoryId = Category::latest('id')->value('id');
        return $latestCategoryId;
    }

    /**
     * Get Categories that have items
     * @author YingMoHom
     * @create 22/06/2023
     * @return latest Id
     */
    public function getItemsCategory()
    {
        //Get Categories do not possess items
        $itemsCategory = DB::table('categories')
            ->leftJoin('items', 'categories.id', 'items.category_id')
            ->whereNull('items.category_id')
            ->select('categories.id', 'categories.category_name')
            ->get();

        // Log::info($itemsCategory);
        return $itemsCategory;
    }

    /**
     * Get Category by category id 
     * @author YingMoHom
     * @create 17/07/2023
     * @return category
     */
    public function getCategory($categoryId)
    {
        //Get Category by category id
        $category = Category::find($categoryId);
        return $category;
    }
}
