<?php
namespace App\Interfaces;
/**
 * Define Interface for Category 
 * @author YingMoHom
 * @create 22/06/2023
 */
interface CategoryInterface
{    
     /**
     * Get categories from storage.
     * @author YingMoHom
     * @create 22/06/2023
     * @return array
     */
    public function getAllCategories();
     /**
     * Get Latest Id from category table.
     * @author YingMoHom
     * @create 22/06/2023
     * @return latest Id
     */
    public function getLatestId();
    /**
     * Get Categories that have items
     * @author YingMoHom
     * @create 22/06/2023
     * @return latest Id
     */
    public  function getItemsCategory();
     /**
     * Get Category by category id 
     * @author YingMoHom
     * @create 17/07/2023
     * @return category
     */
    public function getCategory($categoryId);

    
    
    
}
