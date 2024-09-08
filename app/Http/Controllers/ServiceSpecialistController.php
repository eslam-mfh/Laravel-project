<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Service;
use App\Models\Service_Specialist;
use App\Models\Specialist;
use Illuminate\Http\Request;

class ServiceSpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service_Specialist  $service_Specialist
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service_Specialist  $service_Specialist
     * @return \Illuminate\Http\Response
     */
    public function edit(Service_Specialist $service_Specialist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service_Specialist  $service_Specialist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service_Specialist $service_Specialist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service_Specialist  $service_Specialist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service_Specialist $service_Specialist)
    {
        //
    }
    public function linkServiceToSpecialist($service_id, $specialist_id)
    {
        $service = Service::find($service_id);
        $specialist = Specialist::find($specialist_id);

        if (!$service || !$specialist) {
            return response()->json(['message' => 'Service or Specialist not found'], 404);
        }

        $serviceSpecialist = new Service_Specialist();
        $serviceSpecialist->service_id = $service->id ;
        $serviceSpecialist->specialist_id = $specialist->id;
        $serviceSpecialist->save();
        return response()->json(['message' => 'Specialist linked to service successfully']);
    }


    public function unlinkServiceFromSpecialist($service_id, $specialist_id)
    {
        $service = Service_Specialist::find($service_id);
        $specialist = Service_Specialist::find($specialist_id);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }
        if (!$specialist) {
            return response()->json(['message' => 'specialist not found'], 404);
        }

        $service->specialists()->detach($specialist_id);

        return response()->json(['message' => 'Specialist unlinked from service successfully']);
    }



    public function getSpecialistNamesByServiceId($service_id)
    {
        // جلب السجلات التي تحتوي على نفس service_id
        $serviceSpecialists = Service_Specialist::where('service_id', $service_id)->get();

        if ($serviceSpecialists->isEmpty()) {
            return response()->json(['message' => 'No specialists found for the given service ID'], 404);
        }

        // جلب جميع معلومات المتخصصين
        $specialistDetails = [];
        foreach ($serviceSpecialists as $serviceSpecialist) {
            $specialist = Specialist::find($serviceSpecialist->specialist_id);
            if ($specialist) {
                $specialistDetails[] = [
                    'id' => $specialist->id,
                    'name' => $specialist->name,
                    'description' => $specialist->description,
                    // أضف أي حقول إضافية تحتاجها هنا
                ];
            }
        }

        return response()->json($specialistDetails);
    }




}
