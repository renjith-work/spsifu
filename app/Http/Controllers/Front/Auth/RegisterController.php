<?php

namespace App\Http\Controllers\Front\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Validator;
use App\User;
use Session;
use Auth;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RegisterController extends Controller
{

    public function register()
    {   
        if(Auth::check()){
            return redirect('/');
        }else{
            if(!session()->has('url.intended'))
            {
                session(['url.intended' => url()->previous()]);
            }
            return view('front.auth.register');
        }
    }
    
    public function store(Request $request)
    {
        if(Auth::check()){
            return redirect('/');
        }else{
            $attributeNames = array(
                'fname' => 'first name',
                'lname' => 'last name'
            );

            $validator = Validator::make($request->all(),[
                'fname'=>'required|max:120',
                'lname'=>'required|max:120',
                'email'=>'required|email|unique:users',
                'password'=>'required|min:6|confirmed',
                'password_confirmation'=>'required_with:password|same:password'
            ],
            [
                'password.confirmed' => 'The passwords entered do not matach.',
                'fname.required' => 'Please provide a first name.',
                'lname.required' => 'Please provide a last name.',
                'email.required' => 'Please provide a valid email.',
                'password.required' => 'Please provide a password of minimum 6 characters.',
            ]);

            $validator->setAttributeNames($attributeNames);

            if ($validator->passes()) {
                $user = new User;
                $user->fname = $request->fname;
                $user->lname = $request->lname;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->save();

                $roles = [11];
                if (isset($roles)) {
                    foreach ($roles as $role) {
                        $role_r = Role::where('id', '=', $role)->firstOrFail();            
                        $user->assignRole($role_r); //Assigning role to user
                    }
                }  
                $user->sendEmailVerificationNotification();
                Auth::login($user);   

                Session::flash('success', 'The user was successfully registered.');
                return redirect()->route('verification.notice');
            }else{
                return redirect()->back()->withInput()->withErrors($validator);
            }
        }
    }

    public function testUser()
    {
        DB::table('users')->delete();
        $user = new User;
        $user->fname = 'Renjith';
        $user->lname = 'R S';
        $user->email = 'info@rsrenjith.com';
        $user->password = Hash::make('passmenow123!');
        $user->save();


        $user->sendEmailVerificationNotification();
        Auth::login($user);

        $users = User::all();
        return response()->json($users);
    }
}
