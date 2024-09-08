<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Offer_Service;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $topSer = Service::where('topServices' , '1')->select('name'  ,'image')->get();
     return response()->json($topSer) ;
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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'topServices' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            if ($request->hasFile('image')) {

                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $validatedData['image'] = '/images/' . $imageName;
            }

            $ser = Service::create($validatedData);

            return response()->json([
                "message" => "Service added successfully",
                "data" => $ser,
                "image_url" => isset($ser->image) ? url($ser->image) : null
            ], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error adding Service", "error" => $e->getMessage()], 500);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $ser = Service::findOrFail($id);
            return response()->json($ser);
        } catch (\Exception $e) {
            return response()->json(["message" => "Service not found", "error" => $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|nullable|numeric',
            'topServices' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $ser = Service::findOrFail($id);


            if ($request->hasFile('image')) {

                if ($ser->image) {
                    $oldImagePath = public_path($ser->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }


                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $validatedData['image'] = '/images/' . $imageName;
            }


            $ser->update($validatedData);

            return response()->json([
                "message" => "Service updated successfully",
                "data" => $ser,
                "image_url" => isset($validatedData['image']) ? url($validatedData['image']) : url($ser->image)
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error updating Service", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $ser = Service::findOrFail($id);


            if (Offer_Service::where('service_id', $id)->exists()) {
                return response()->json(["message" => "Cannot delete service. It is associated with an offer and must be deleted from the offer first."], 400);
            }

            $ser->delete();
            return response()->json(["message" => "Service deleted successfully"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error deleting Service", "error" => $e->getMessage()], 500);
        }
    }


    public function allservice ()
    {
        $ser = Service::all('id','name' , 'image');
        return response()->json($ser);
    }


    public function getCategory($id)
    {
        $services = Service::where('category_id', $id)
            ->select('name', 'image')
            ->get();
        return response()->json($services);
    }

    public function service ($id)
    {
        $ser = Service::where('id' , $id)->first();
        return response()->json($ser);
    }

    public function getCategoryDashboard($id)
    {
        $services = Service::where('category_id', $id)->get();
        return response()->json($services);
    }
}
