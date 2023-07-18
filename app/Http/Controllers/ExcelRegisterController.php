<?php

namespace App\Http\Controllers;

use App\Exports\ExcelExport;
use App\Http\Requests\ExcelRegisterRequest;
use App\Imports\ExcelImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;


/**
 * Create Controller to Manage Excel Export and Import File
 * @author YingMoHom
 * @create 26/06/2023
 */
class ExcelRegisterController extends Controller
{
    /**
     * Create Excel Download Format
     * @author YingMoHom
     * @create 23/06/2023
     */
    
    public function export()
    {
        return Excel::download(new ExcelExport, 'Item_List.xlsx');
    }

    /**
     * Import Data From Excel to Database
     * @author YingMoHom
     * @create 26/06/2023
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(ExcelRegisterRequest $request)
    {
        //If the file is excel file import data from it
        try {

            $file = $request->file('file');
            Excel::import(new ExcelImport(), $file);
            return redirect()->route('items.list')->with('success', 'Your Data store Successfully');

        } catch (\Exception $e) {
       
            return redirect()->route('excel.registers')->with('error-message', $e->getMessage());
            
        }
    }
}
