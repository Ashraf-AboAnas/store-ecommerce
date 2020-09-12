<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingsRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function editShippingMethods($type)
    {
        //free , inner , outer for shipping methods

        if ($type === 'free') {
            //return 'free';
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();
        } elseif ($type === 'inner') {
            //  return 'inner';
            $shippingMethod = Setting::where('key', 'local_label')->first();
        } elseif ($type === 'outer') {
            // return 'outer';
            $shippingMethod = Setting::where('key', 'outer_label')->first();
        } else {
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();
        }

        return view('dashboard.settings.shippings.edit', compact('shippingMethod'));

    }
    public function updateShippingMethods(ShippingsRequest $request, $id)
    {

      //return $request;  //test begining before updata
         //validation

        //update db

        try {
            $shipping_method = Setting::findOrfail($id);

            DB::beginTransaction();
            $shipping_method->update([
                'plain_value' =>$request->post('plain_value')  //or //$request->plain_value
                ]);
            //save translations
            $shipping_method->value = $request->value;
           // return $shipping_method;
            $shipping_method->save();

            DB::commit();
            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'هناك خطا ما يرجي المحاولة فيما بعد']);
            DB::rollback();
        }

    }
}
