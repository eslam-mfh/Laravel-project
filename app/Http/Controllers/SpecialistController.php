<?php

namespace App\Http\Controllers;

use App\Models\AvailableSlot;
use App\Models\Service;
use App\Models\Service_Specialist;
use App\Models\Session;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialists = Specialist::all()->map(function ($specialist) {
            $specialist_id = $specialist->id;

            // جلب service_id المرتبطة بالأخصائي
            $service_ids = Service_Specialist::where('specialist_id', $specialist_id)
                ->pluck('service_id');

            // جلب أسماء الخدمات بناءً على service_id
            $service_names = Service::whereIn('id', $service_ids)
                ->pluck('name');

            return [
                'id' => $specialist->id,
                'name' => $specialist->name,
                'description' => $specialist->description,
                'image' => $specialist->image,

                'services' => $service_names
            ];
        });

        return response()->json($specialists);
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
        // التحقق من صحة البيانات المرسلة
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // تحقق من الصورة
        ]);

        try {
            // معالجة الصورة إذا كانت موجودة
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $validatedData['image'] = $imageName;
            }

            // إنشاء الـ Specialist باستخدام البيانات المرسلة
            $specialist = Specialist::create($validatedData);

            return response()->json([
                "message" => "Specialist added successfully",
                "data" => $specialist,
                "image_url" => isset($validatedData['image']) ? url('images/' . $validatedData['image']) : null
            ], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error adding specialist", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Specialist  $specialist
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $specialist=Specialist::findOrFail( $id);
        return response()->json($specialist);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specialist  $specialist
     * @return \Illuminate\Http\Response
     */
    public function edit(Specialist $specialist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specialist  $specialist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->role_id == 2) {
            // التحقق من صحة البيانات المرسلة
            $validatedData = $request->validate([
                'name' => 'string|max:255',
                'description' => 'string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // تحقق من الصورة
            ]);

            try {
                // العثور على السجل المطلوب
                $specialist = Specialist::findOrFail($id);

                // تحديث البيانات الأساسية
                if ($request->has('name')) {
                    $specialist->name = $request->input('name');
                }
                if ($request->has('description')) {
                    $specialist->description = $request->input('description');
                }

                // معالجة الصورة إذا كانت موجودة
                if ($request->hasFile('image')) {
                    // حذف الصورة القديمة إذا كانت موجودة
                    if ($specialist->image) {
                        $oldImagePath = public_path('images/' . $specialist->image);
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    // حفظ الصورة الجديدة
                    $imageName = time() . '.' . $request->image->extension();
                    $request->image->move(public_path('images'), $imageName);
                    $specialist->image = $imageName;
                }

                // حفظ التغييرات
                $specialist->save();

                return response()->json([
                    "message" => "Specialist updated successfully",
                    "data" => $specialist,
                    "image_url" => isset($specialist->image) ? url('images/' . $specialist->image) : null
                ], 200);

            } catch (\Exception $e) {
                return response()->json(["message" => "Error updating Specialist", "error" => $e->getMessage()], 500);
            }
        } else {
            return response()->json("Unauthorized", 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specialist  $specialist
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        if (auth()->user()->role_id == 2 ) {
            $specialist = Specialist::findOrFail($id);
            $specialist->delete();
            return response()->json("deleted");
        } else {
            return response()->json("Unauthorized", 403);
        }
    }



    public function bookSlot(Request $request, $id)
    {
        $slot = AvailableSlot::findOrFail($id);
        if ($slot->is_booked == false) {

            $specialist = Specialist::find($slot->specialist_id);
            if (!$specialist) {
                return response()->json(['message' => 'Specialist not found'], 404);
            }
            $service = Service::find($slot->service_id);
            if (!$service) {
                return response()->json(['message' => 'Service not found'], 404);
            }

            $serviceSpecialist = Service_Specialist::where('service_id', $slot->service_id)
                ->where('specialist_id', $slot->specialist_id)
                ->first();

            if (!$serviceSpecialist) {
                return response()->json(['message' => 'No record found linking the service and specialist'], 404);
            }

            $service = Service::findOrFail($slot->service_id);
            $specialist = Specialist::findOrFail($slot->specialist_id);

            // حفظ بيانات الحجز في جدول sessions
            $session = new Session();
            $session->user_id = $request->user()->id;
            $session->available_slots_id = $slot->id;
            $session->service = $service->name;
            $session->specialist = $specialist->name;
            $session->date = $slot->date;
            $session->time = $slot->time;
            $session->status = 0; // حالة الحجز الافتراضية
            $session->save();
            $slot->is_booked = true;
            $slot->save();
            return response()->json('success');
        } else {
            return response()->json('unavailable slot');
        }
    }


    public function available(Request $request, $service_id, $specialist_id)
    {
        $serviceSpecialist = Service_Specialist::where('service_id', $service_id)
            ->where('specialist_id', $specialist_id)
            ->first();

        if (!$serviceSpecialist) {
            return response()->json(['message' => 'No record found linking the service and specialist'], 404);
        }

        AvailableSlot::where('specialist_id', $specialist_id)
            ->where('service_id', '!=', $service_id)
            ->update(['service_id' => $service_id]);

        $existingSlots = AvailableSlot::where('specialist_id', $specialist_id)
            ->get(['date', 'time'])
            ->groupBy('date')
            ->map(function ($slot) {
                return $slot->pluck('time')->map(function ($time) {
                    return Carbon::createFromFormat('H:i:s', $time)->format('H:i');
                })->toArray();
            });

        $availableSlots = [];
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addDays(30);

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dateKey = $date->format('Y-m-d');

            for ($hour = 9; $hour < 17; $hour++) {
                for ($minute = 0; $minute < 60; $minute += 30) {
                    $timeKey = $date->copy()->setTime($hour, $minute)->format('H:i');

                    if (!AvailableSlot::where('specialist_id', $specialist_id)
                            ->where('date', $dateKey)
                            ->where('time', $timeKey)
                            ->exists() &&
                        (!isset($existingSlots[$dateKey]) || !in_array($timeKey, $existingSlots[$dateKey]))) {

                        $availableSlots[] = [
                            'specialist_id' => $specialist_id,
                            'service_id' => $service_id,
                            'date' => $dateKey,
                            'time' => $timeKey,
                            'is_booked' => false,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }
            }
        }

        if (!empty($availableSlots)) {
            AvailableSlot::insert($availableSlots);
        }

        $requestedDate = $request->query('date');
        if (!$requestedDate) {
            return response()->json(['message' => 'Date parameter is required'], 400);
        }

        $date = Carbon::createFromFormat('Y-m-d', $requestedDate);
        if (!$date) {
            return response()->json(['message' => 'Invalid date format'], 400);
        }

        $available = AvailableSlot::where('specialist_id', $specialist_id)
            ->where('is_booked', false)
            ->whereDate('date', $date->format('Y-m-d'))
            ->get(['id', 'time'])
            ->map(function ($slot) {
                $slot->time = Carbon::createFromFormat('H:i:s', $slot->time)->format('H:i');
                return $slot;
            });

        return response()->json($available);
    }


    ////////////////////////////////////////////////////////////////////////////////////





}
