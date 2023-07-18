<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExcelRegisterController;
use App\Http\Controllers\NormalRegisterController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LanguageController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login.form');
});

//Route for show Excel Register Form
Route::get('/excel-registers',function(){
    return view('register.excelRegister');
})->name('excel.registers');

//Route for show Login Form
Route::get('/login-form',[EmployeeController::class,'showLoginForm'])->name('login.form');

//Route for processing login
Route::post('/login',[EmployeeController::class,'login'])->name('login');


//Route for show normal register form
Route::get('/normal-registers',[NormalRegisterController::class,'create'])->name('normal.registers');
//Route for store item 
Route::post('/item-store',[NormalRegisterController::class,'store'])->name('store.item');


//Route for store category from  normal register form
Route::post('/categories-store',[NormalRegisterController::class,'storeCategory'])->name('categories.store');


//Route for  remove category from normal register form
Route::post('/categories-remove',[NormalRegisterController::class,'removeCategory'])->name('categories.remove');

//Route for get latest category id
Route::get('/getLatestCategoryId',[NormalRegisterController::class,'getLatestCategoryId'])->name('get-latestCategory-id');

//Route for export excel
Route::get('/export',[ExcelRegisterController::class,'export'])->name('export');

//Route for import excel
Route::post('import',[ExcelRegisterController::class,'import'])->name('import');

//Route for show Item List
Route::get('/items-list',[ItemController::class,'index'])->name('items.list');

//Route for fetch Item Name and Item Code according to Item Id
Route::post('/items-fetch',[ItemController::class,'fetch'])->name('items.fetch');

//Route for seraching items
Route::get('/items-search',[ItemController::class,'search'])->name('items.search');

// Define route for pdfDownload
Route::get('/items-pdfDownload', [ItemController::class,'pdfDownload'])->name('items.pdfDownload');

// Define route for excelDownload
Route::get('/items-excelDownload', [ItemController::class,'excelDownload'])->name('items.excelDownload');

// Define route to change active to inactive
Route::put('/update-active-status', [ItemController::class,'updateActiveStatus'])->name('update-active-status');

// Define route to change inactive to active
Route::put('/update-inactive-status', [ItemController::class,'updateInactiveStatus'])->name('update-inactive-status');

// Define route to hard delete item
Route::post('/item-delete', [ItemController::class,'destroy'])->name('item.delete');

// Define route to show edit form
Route::get('/item-edit/{id}', [ItemController::class,'edit'])->name('item.edit');

// Define route to update data
Route::post('/item-update', [ItemController::class,'update'])->name('item.update');

// Define route to show item detail
Route::get('/item-detail/{id}', [ItemController::class,'show'])->name('item.detail');

// Define route to delete Image
Route::post('/image-delete', [ItemController::class,'deleteImage'])->name('image.delete');

//Define route for change language
Route::get('locale/{locale}', [LanguageController::class,'setLang'])->name('language');

// //Define route for autocomplete
Route::get('/autocomplete/itemId', [ItemController::class,'autocompleteItemId']);
Route::get('/autocomplete/itemCode', [ItemController::class,'autocompleteItemCode']);
Route::get('/autocomplete/itemName', [ItemController::class,'autocompleteItemName']);







