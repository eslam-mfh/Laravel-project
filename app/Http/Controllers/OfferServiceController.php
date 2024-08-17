<?php

namespace App\Http\Controllers;

use App\Models\Offer_Service;
use Illuminate\Http\Request;
use App\Models\Service ;

class OfferServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $request->validate([
            'offer_id' => 'required|exists:offers,id',
            'service_id' => 'required|exists:services,id',
        ]);

        // إنشاء ارتباط بين العرض والخدمة
        $offerService = new Offer_Service();
        $offerService->offer_id = $request->query('offer_id');
        $offerService->service_id = $request->query('service_id');
        $offerService->save();

        return response()->json(['message' => 'Offer and Service linked successfully!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer_Service  $offer_Service
     * @return \Illuminate\Http\Response
     */
    public function show(Offer_Service $offer)
    {
        $offers=Offer_Service::where('id' , $offer)->get('service_id') ;
        //$ser=Offer_Service::where('Offer_id' ,$offer ) ;
        $service = Service::where('id', $offers )->get();
        return response()->json($service);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer_Service  $offer_Service
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer_Service $offer_Service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer_Service  $offer_Service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer_Service $offer_Service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer_Service  $offer_Service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer_Service $offer_Service)
    {
        //
    }
    public function services ($id)
    {
        $offers=Offer_Service::where('id' , $id)->get('service_id') ;
        //$ser=Offer_Service::where('Offer_id' ,$offer ) ;
        $service = Service::where('id', $offers )->get('name');
        return response()->json($service );
    }
}
