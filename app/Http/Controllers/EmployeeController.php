<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;

/**
 * Create Controller For Employee LogIn
 * @author YingMoHom
 * @create 21/06/2023
 */
class EmployeeController extends Controller
{
    /**
     * Show Login Form.
     * @author YingMoHom
     * @create 21/06/2023
     */
    public function showLoginForm()
    {

        return view('login.login');
    }


     /**
     * Check  Employee ID and Password
     * @author YingMoHom
     * @create 21/06/2023
     * @param  LoginRequest  $request
     * @return view
     */
    public function login(LoginRequest $request)

    {
        $credentials = [
            'emp_id' => $request->input('emp_id'),
            'emp_pwd' => $request->input('emp_pwd'),
        ];

        $emp = DB::table('employees')
            ->where('emp_id', $credentials['emp_id'])
            ->first();

        if ($emp) {

            if (password_verify($credentials['emp_pwd'], $emp->password)) {
                // Authentication Passed


                return redirect()->route('items.list')->with('success', 'Log In Successfully!');;
            } else {
                // Password is not correct
                return redirect()->back()->withErrors(['message' => 'Invalid Password']);
            }
        } else {
            // EmployeeID  is not correct
            return redirect()->back()->withErrors(['message' => 'Invalid Employee ID  or Password']);
        }
       
    }
}
