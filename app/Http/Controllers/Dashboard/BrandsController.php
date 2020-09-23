<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandsController extends Controller
{

    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(PAGENATION_COUNT);
        return view('dashboard.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('dashboard.brands.create');
    }

    public function store(BrandRequest $request)
    {

        DB::beginTransaction();

        //validation

        if (!$request->has('is_active')) {
            $request->request->add(['is_active' => 0]);
        } else {
            $request->request->add(['is_active' => 1]);
        }

        $fileName = "";
        if ($request->has('photo')) {

            $fileName = uploadImage('brands', $request->photo);
        }

        $brand = Brand::create($request->except('_token', 'photo'));

        //save translations
        $brand->name = $request->name;
        $brand->photo = $fileName;

        $brand->save();
        DB::commit();
        return redirect()->route('admin.brands.index')->with(['success' => 'تم ألاضافة بنجاح']);

    }

    public function edit($id)
    {

        //get specific categories and its translations
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->route('admin.brands,index')->with(['error' => 'هذا الماركة غير موجود']);
        }

        return view('dashboard.brands.edit', compact('brand'));

    }

    public function update($id, BrandRequest $request)
    {
        try {
            //validation

            //update DB

            $brand = Brand::find($id);

            if (!$brand) {
                return redirect()->route('admin.brands.index')->with(['error' => 'هذا الماركة غير موجود']);
            }

            DB::beginTransaction();

            /************************************** */
        //     $data = $request->except('photo');


        //     if ($request->hasfile('photo') && $request->file('photo')->isvalid()) {
        //         $image = $request->file('photo');

        //         if ($brand->photo && Storage::disk('brands')->exists($brand->photo)) { //if image Exist or old image in brands اذا كام المنتج الو صوره وبدك تعدل عليها

        //             $fileName = $image->storeAs('', basename($brand->photo), 'brands'); // Updated new image same name pre-image(disk in brands from file system)
        //            // dd($fileName);
        //          }
        //          else {
        //            //  dd('ho daaaaaaaa');
        //             //if not found old image -- save  New image and ne Name To Images Disk
        //             $fileName = $image->store('', 'brands'); //storge disk
        //            // dd($fileName);
        //             }



        //         $data['photo'] = $fileName;



        //     }
        //     $brand->update($data);
        //    //save translations
        //     $brand->name = $request->name;
        //     $brand->save();

            /****************************************** */
            if ($request->has('photo')) {
                deleteImage($brand->photo);
               // Storage::disk('brands')->delete($brand->photo);
                $fileName = uploadImage('brands', $request->photo);
                Brand::where('id', $id)
                    ->update([
                        'photo' => $fileName,
                    ]);
            }

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $brand->update($request->except('_token', 'id', 'photo'));

            //save translations
            $brand->name = $request->name;
            $brand->save();

            DB::commit();
            return redirect()->route('admin.brands.index')->with(['success' => 'تم ألتحديث بنجاح']);

        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->route('admin.brands.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $brand = Brand::find($id);

            if (!$brand) {
                return redirect()->route('admin.brands.index')->with(['error' => 'هذا الماركة غير موجود ']);
            }

            if ($brand->photo) {
                $brand->delete();
                $brand->translation()->delete();

                // unlink(public_path('images/'.$products->image));//in php native
                deleteImage($brand->photo);



               // Storage::disk('brands')->delete($brand->photo); // in laravel to delete image from images disk
                return redirect()->route('admin.brands.index')->with(['success' => 'تم  الحذف بنجاح']);
            }
        } catch (\Exception $ex) {
            return redirect()->route('admin.brands.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

}
