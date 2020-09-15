<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;

class ProfileController extends Controller
{
    public function editprofile()
    {

        $admin = Admin::findOrfail(auth()->user()->id);
        //dd($admin);
        return view('dashboard.profiles.edit', [
            'admin' => $admin,

        ]);
    }
    public function updataprofile(ProfileRequest $request)
    {
        try {
            $admin = Admin::findOrfail(auth()->user()->id); //to select row (admin->id) from admins to update
            // if($request->filled('password')){ // filled لابد ان يحمل قيمه حتي يتحقق بخلاف هاس
            //      $request ->merge([
            //         'password'=>bcrypt($request->post('password'))
            //         ]);
            // }
           // to dont return with request we use unset;
           // بديل عن جمله الاف استخدمنا دالة setPasswordAttribute في الموديل ادمن لكي يحول الباسور مشفر
           unset($request['id']); //iuput hidden
           unset($request['password_confirmation']);// in form but not find in DB.

          // return $admin;
           $admin->update($request->all());
            // Another method to Update
          // $admin->update($request->only(['name', 'email']));
            //    $admin->update([
            //     'name' => $request->post('name'),
            //     'email' => $request->post('email'),
            //     'password' => bcrypt ($request->post('password'))
            //   ]);
            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'هناك خطا ما يرجي المحاولة فيما بعد']);

        }
        //
    }
}
