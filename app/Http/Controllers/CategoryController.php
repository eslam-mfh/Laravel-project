<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCat= Category::all( 'id','name' ,'description', 'image') ;
        return response()->json($allCat);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // التحقق من صحة الصورة
        ]);

        // معالجة الصورة إذا كانت موجودة
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $validatedData['image'] = $imageName;
        }

        try {
            $cat = Category::create($validatedData);

            return response()->json([
                "message" => "Category added successfully",
                "data" => $cat,
                "image_url" => isset($validatedData['image']) ? url('images/'.$validatedData['image']) : null // تضمين رابط الصورة في الاستجابة
            ], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error adding category", "error" => $e->getMessage()], 500);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $cat=Category::findOrFail( $id);
        return response()->json($cat);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // التحقق من صحة الصورة
        ]);

        try {
            $cat = Category::findOrFail($id);

            // معالجة الصورة إذا كانت موجودة
            if ($request->hasFile('image')) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($cat->image) {
                    $oldImagePath = public_path('images/'.$cat->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // حفظ الصورة الجديدة في ملف
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $validatedData['image'] = $imageName;
            }

            $cat->update($validatedData);

            return response()->json([
                "message" => "Category updated successfully",
                "data" => $cat,
                "image_url" => isset($validatedData['image']) ? url('images/'.$validatedData['image']) : url('images/'.$cat->image)
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error updating category", "error" => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $cat = Category::findOrFail($id);
        $cat->delete();
        return response()->json("deleted");
    }
}
