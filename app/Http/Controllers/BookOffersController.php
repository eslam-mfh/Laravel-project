<?php

namespace App\Http\Controllers;

use App\Models\BookOffers;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BookOffersController extends Controller
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
     * @param  \App\Models\BookOffers  $bookOffers
     * @return \Illuminate\Http\Response
     */
    public function show(BookOffers $bookOffers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookOffers  $bookOffers
     * @return \Illuminate\Http\Response
     */
    public function edit(BookOffers $bookOffers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookOffers  $bookOffers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookOffers $bookOffers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookOffers  $bookOffers
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookOffers $bookOffers)
    {
        //
    }
    public function availableforoffer(Request $request, $offer_id)
    {
        // الحصول على التاريخ من معامل URL
        $requestedDate = $request->query('date');
        if (!$requestedDate) {
            return response()->json(['message' => 'Date parameter is required'], 400);
        }

        // التحقق من صحة التاريخ
        $date = Carbon::createFromFormat('Y-m-d', $requestedDate);
        if (!$date) {
            return response()->json(['message' => 'Invalid date format'], 400);
        }

        // جلب المواعيد المحجوزة في التاريخ المحدد
        $bookedSlots = DB::table('book_offers')
            ->whereDate('date', $date->format('Y-m-d'))
            ->get(['time'])
            ->pluck('time')
            ->map(function ($time) {
                return Carbon::createFromFormat('H:i:s', $time)->format('H:i');
            })
            ->toArray();

        // إنشاء الأوقات المتاحة في اليوم المحدد
        $availableSlots = [];
        for ($hour = 9; $hour < 17; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 30) {
                $timeKey = Carbon::createFromTime($hour, $minute)->format('H:i');

                // تحقق مما إذا كان الموعد غير محجوز
                if (!in_array($timeKey, $bookedSlots)) {
                    $availableSlots[] = $timeKey;
                }
            }
        }

        return response()->json($availableSlots);
    }

    public function bookSlotforoffer(Request $request, $offer_id)
    {
        // التحقق من المدخلات
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i',
        ]);

        $date = $request->input('date');
        $time = $request->input('time');

        // التحقق من عدم وجود سجل آخر بنفس التاريخ والوقت
        $existingBooking = DB::table('book_offers')
            ->where('offer_id', $offer_id)
            ->where('date', $date)
            ->where('time', $time)
            ->exists();

        if ($existingBooking) {
            return response()->json('unavailable slot', 400);
        }

        // جلب العرض من قاعدة البيانات
        $offer = Offer::find($offer_id);
        if (!$offer) {
            return response()->json(['message' => 'Offer not found'], 404);
        }

        // حفظ بيانات الحجز في جدول book_offers
        DB::table('book_offers')->insert([
            'user_id' => $request->user()->id,
            'offer_id' => $offer_id,
            'date' => $date,
            'time' => $time,
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // حفظ بيانات الحجز في جدول sessions
        DB::table('sessions')->insert([
            'user_id' => $request->user()->id,
            'service' => $offer->name,  // Assuming the offer has a 'name' attribute
            'date' => $date,
            'time' => $time,
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json('success');
    }


}
