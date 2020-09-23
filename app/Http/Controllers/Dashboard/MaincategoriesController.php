<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use DB;
class MaincategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd('dfghjk');
        $categories = Category::parent()->paginate(PAGENATION_COUNT); //Category::where('parent_id','=',null)
        $categories->makeVisible(['tranlations']);
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MainCategoryRequest $request)
    {

        try {

          DB::beginTransaction();

            //validation

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category = Category::create($request->except('_token'));

            //save translations
            $category->name = $request->name;
            $category->save();
            //dd($category);
            DB::commit();
            return redirect()->route('admin.maincategories.index')->with(['success' => 'تم ألاضافة بنجاح']);


        } catch (\Exception $ex) {
          DB::rollback();
            return redirect()->route('admin.maincategories.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $category = Category::find($id);
        //  dd($category);
        if (!$category) {
            return redirect()->route('admin.maincategories.index')->with(['error' => 'هذا القسم غيرموجود']);
        }

        return view('dashboard.categories.edit', compact('category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MainCategoryRequest $request, $id)
    {
        //  dd('uiuiiiiiiiiiiiiii');
        try {
            //code...
            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }

            $category = Category::orderBy('id', 'DESC')->find($id);

            //  dd($category);
            if (!$category) {
                return redirect()->route('admin.maincategories.index')->with(['error' => 'هذا القسم غيرموجود']);
            }
            //dd($request->all());
            $category->update($request->all());

            $category->name = $request->name; // عشان الاسم في جدول الترجمه خارج الفيلبل
            $category->save();
            return redirect()->route('admin.maincategories.index')->with(['success' => 'تم التحديث بنجاح  ']);

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('admin.maincategories.index')->with(['error' => 'هناك خطا ما يرجي المحاولة فيما بعد']);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // dd('ddddddddddddddd');
        try {

            $category = Category::orderBy('id', 'DESC')->find($id);

            if (!$category) {
                return redirect()->route('admin.maincategories.index')->with(['error' => 'هذا القسم غيرموجود']);
            }
            $category->delete();
            $category->translation()->delete();
            return redirect()->route('admin.maincategories.index')->with(['success' => 'تم الحذف بنجاح  ']);

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('admin.maincategories.index')->with(['error' => 'هناك خطا ما يرجي المحاولة فيما بعد']);

        }
    }
}
