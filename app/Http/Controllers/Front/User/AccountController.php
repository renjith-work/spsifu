<?php

namespace App\Http\Controllers\Front\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use Validator;
use Session;

class AccountController extends Controller
{
    public function index()
    {	
    	$user = Auth::user();
    	return view('front.user.accountDetails')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
    	 $validator = Validator::make($request->all(),[
            'fname'=>'required|max:120',
            'lname'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$id,
        ]);

    	 if ($validator->passes()) {
            $user = User::findOrFail($id); 
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->save();
            if (isset($request->roles)) {
                foreach ($request->roles as $role) {
                    $role_r = Role::where('id', '=', $role)->firstOrFail();            
                    $user->assignRole($role_r); //Assigning role to user
                }
            } 

            Session::flash('success', 'your account details where successfully updated.');
            return redirect()->back();
        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }
}
