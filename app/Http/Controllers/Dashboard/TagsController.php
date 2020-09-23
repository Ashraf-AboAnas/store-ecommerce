<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagsRequest;
use App\Models\Tag;
use DB;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC')->paginate(PAGENATION_COUNT);
        return view('dashboard.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('dashboard.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //TagsRequest
    public function store(TagsRequest $request)
    {
        try {

            //DB::beginTransaction();

            //validation

             $tags = Tag::create($request->except('_token'));
            //  $tags->makeVisable(['tranlations']);
            //  return   $tags;
            
            // save translations
            $tags->name = $request->name;
            $tags->save();

            DB::commit();
            return redirect()->route('admin.tags.index')->with(['success' => 'تم ألاضافة بنجاح']);
        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->route('admin.tags.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
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
        //get specific categories and its translations
        $tag = Tag::find($id);


        if (!$tag) {
            return redirect()->route('admin.tags.index')->with(['error' => 'هذا الماركة غير موجود ']);
        }

        return view('dashboard.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            //validation

            //update DB

            $tag = Tag::find($id);

            if (!$tag) {
                return redirect()->route('admin.tags.index')->with(['error' => 'هذا الماركة غير موجود']);
            }

            DB::beginTransaction();

            $tag->update($request->except('_token', 'id')); // update only for slug column

            //save translations
            $tag->name = $request->name;
            $tag->save();

            DB::commit();
            return redirect()->route('admin.tags.index')->with(['success' => 'تم ألتحديث بنجاح']);

        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->route('admin.tags.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
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
        try {
            //get specific categories and its translations
            $tags = Tag::find($id);

            if (!$tags) {
                return redirect()->route('admin.tags.index')->with(['error' => 'هذا الماركة غير موجود ']);
            }

            $tags->delete();
            $tags->translation()->delete();

            return redirect()->route('admin.tags.index')->with(['success' => 'تم  الحذف بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.tags.index')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

}
