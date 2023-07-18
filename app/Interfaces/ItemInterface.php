<?php

namespace App\Interfaces;

/**
 * Define Interface for Item 
 * @author YingMoHom
 * @create 22/06/2023
 */
interface ItemInterface
{
  /**
   * Get  Latest Id From Item Table.
   * @author YingMoHom
   * @create 22/06/2023
   * @return latest Id
   */
  public function getLatestId();
  /**
   * Get Items From storage.
   * @author YingMoHom
   * @create 22/06/2023
   * @return array
   */
  public function getAllItems();
  /**
   * Get Items According to search data.
   * @author YingMoHom
   * @create 26/06/2023
   * @param \Illuminate\Http\Request  $request
   * @return array
   */
  public function getSearchItems($request);
  /**
   * Get Items According to given id.
   * @author YingMoHom
   * @create 03/07/2023
   * @param $id
   * @return item search by id
   */
  public function getItemById($id);
  /**
   * Get Items According to given item id.
   * @author YingMoHom
   * @create 30/06/2023
   * @param $itemId
   * @return item search by item id
   */
  public function getItemByItemId($itemId);
  /**
   * Get All Items for download
   * @author YingMoHom
   * @create 03/07/2023
   * @return array
   */
  public function getAllItemsForDownLoad();
  /**
   * Get All Items , Category and Photo  for update form 
   * @author YingMoHom
   * @create 03/07/2023
   * @return array
   */
  public function getItemDataById($id);

  /**
   * Get All Items , Category and Photo  for detail
   * @author YingMoHom
   * @create 06/07/2023
   * @return array
   */

  public function getDataForDetail($id);
  /**
   *  Make autocomplete for item id
   * @author YingMoHom
   * @create 12/07/2023
   * @return array
   */

  public function autocompleteItemId($itemId);
  /**
   * Make autocomplete for item code
   * @author YingMoHom
   * @create 12/07/2023
   * @return array
   */

  public function autocompleteItemCode($itemCode);

  /**
   * Make autocomplete for item name
   * @author YingMoHom
   * @create 12/07/2023
   * @return array
   */

  public function autocompleteItemName($itemName);
}
