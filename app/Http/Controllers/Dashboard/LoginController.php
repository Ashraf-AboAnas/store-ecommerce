<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest; //to validation
use Illuminate\Http\Request;

class LoginController extends Controller
{
   public function login (){
     return view('dashboard.auth.login');

   }
  
   public function postlogin (AdminLoginRequest $request){
 // return $request; // check if function goto  success rout In action form  action="{{route('admin.postlogin')}}.
 $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
           // notify()->success('تم الدخول بنجاح  ');
           //return'hhhhhhhhhhhhhhhhhhhhhh'; // test
            return redirect() -> route('admin.dashboard');
        }
       // notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');
        return redirect()->back()->with(['error' => 'هناك خطا بالبيانات']);

    }
}
