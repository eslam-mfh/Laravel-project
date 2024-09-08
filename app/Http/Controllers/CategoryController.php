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
        $allCat = Category::all(['id', 'name', 'description', 'image']);


        $allCat = $allCat->map(function ($cat) {
            $cat->image_url = $cat->image ? url('images/' . $cat->image) : null;
            return $cat;
        });

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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validatedData['image'] = '/images/' . $imageName;
        }

        try {
            $cat = Category::create($validatedData);
            return response()->json([
                "message" => "Category added successfully",
                "data" => $cat,
                "image_url" => isset($validatedData['image']) ? url($validatedData['image']) : null
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $cat = Category::findOrFail($id);


            if ($request->hasFile('image')) {

                if ($cat->image) {
                    $oldImagePath = public_path($cat->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }


                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $validatedData['image'] = '/images/' . $imageName;
            }

            $cat->update($validatedData);

            return response()->json([
                "message" => "Category updated successfully",
                "data" => $cat,
                "image_url" => isset($validatedData['image']) ? url($validatedData['image']) : url($cat->image)
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
