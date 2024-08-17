<?php

namespace App\Http\Controllers\API;

use App\Models\Blog;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();
        return response([ 'blogs' => BlogResource::collection($blogs), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required|max:80',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $user_id = auth()->user()->id;

        $data["user_id"] = $user_id;

        $blog = Blog::create($data);

        return response([ 'blog' => new BlogResource($blog), 'message' => 'Created successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return response([ 'blog' => new BlogResource($blog), 'message' => 'Retrieved successfully'], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {

        $blog->update($request->all());

        return response([ 'blog' => new BlogResource($blog), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Blog $blog
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return response(['message' => 'Deleted']);
    }
}
