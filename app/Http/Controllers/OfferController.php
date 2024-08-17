<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Offer_Service;
use Illuminate\Http\Request;
use App\Models\Service;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alloff = Offer::where('type' , '0')->get();
        return response()->json($alloff);
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
            'description' => 'required|string',
            'price' => 'required|integer',
            'type' => 'required|integer|in:0,1',
            'end' => 'required|date',

        ]);

        $offer = Offer::create($validatedData);
        return response()->json(["message" => "Offer added successfully", "data" => $offer], 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        //
    }
    public function updateTypeZero(Request $request, $id)
    {
        $offer = Offer::where('id', $id)->where('type', 0)->firstOrFail();
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'integer',
        ]);

        $offer->update($validatedData);
        return response()->json(["message" => "Offer updated successfully", "data" => $offer], 200);
    }

    public function updateTypeOne(Request $request, $id)
    {
        $offer = Offer::where('id', $id)->where('type', 1)->firstOrFail();
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'integer',
        ]);

        $offer->update($validatedData);
        return response()->json(["message" => "Offer updated successfully", "data" => $offer], 200);
    }

    public function destroyTypeZero($id)
    {
        $offer = Offer::where('id', $id)->where('type', 0)->firstOrFail();
        $offer->delete();
        return response()->json(["message" => "Offer deleted successfully"], 200);
    }

    public function destroyTypeOne($id)
    {
        $offer = Offer::where('id', $id)->where('type', 1)->firstOrFail();
        $offer->delete();
        return response()->json(["message" => "Offer deleted successfully"], 200);
    }


    public function services($id)
    {
        // جلب الـ service_id المرتبطة بالعرض
        $offer_services = Offer_Service::where('offer_id', $id)->pluck('service_id');

        // جلب تفاصيل العرض
        $offer_details = Offer::find($id);

        // جلب تفاصيل الخدمات المرتبطة بالعرض
        $services = Service::select('name', 'description')->whereIn('id', $offer_services)->get();

        // إنشاء الرد مع تفاصيل العرض والخدمات
        $response = [
            'offer' => $offer_details,
            'services' => $services,
        ];

        return response()->json($response);
    }


    public function soon()
    {
        $alloff = Offer::where('type' , 1)->get();
        return response()->json($alloff);
    }
}
