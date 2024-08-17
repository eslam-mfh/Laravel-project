<?php

namespace App\Http\Controllers;

use App\Models\AvailableSlot;
use App\Models\Service;
use App\Models\Service_Specialist;
use App\Models\Session;
use App\Models\Specialist;
use Illuminate\Http\Request;
use App\Models\Reviews;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show(Session $session)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function edit(Session $session)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Session $session)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        //
    }
    public function refuseSession(Request $request, $id)
    {
        $session = Session::findOrFail($id);

        // التحقق من حالة الجلسة
        if ($session->status == 0) {
            // تغيير حالة الجلسة إلى مرفوضة
            $session->status = 3;
            $session->save();

            // التحقق من نوع الجلسة
            if ($session->type == 1) {
                // جلب السجل المقابل في جدول book_offers وتحديث حالته
                $bookOffer = DB::table('book_offers')
                    ->where('user_id', $session->user_id)
                    ->where('offer_id', $session->service_id) // Assuming service_id corresponds to offer_id in sessions
                    ->where('date', $session->date)
                    ->where('time', $session->time)
                    ->first();

                if ($bookOffer) {
                    DB::table('book_offers')
                        ->where('id', $bookOffer->id)
                        ->update(['status' => 3, 'updated_at' => Carbon::now()]);
                }
            }

            return response()->json(['message' => 'Session refused successfully', 'session' => $session]);
        } else {
            return response()->json(['message' => 'Session cannot be refused'], 403);
        }
    }


    public function approveSession(Request $request, $id)
    {
        $session = Session::findOrFail($id);

        // التحقق من حالة الجلسة
        if ($session->status == 0) {
            // تغيير حالة الجلسة إلى موافق عليها
            $session->status = 1;
            $session->save();

            // التحقق من نوع الجلسة
            if ($session->type == 1) {
                // جلب السجل المقابل في جدول book_offers وتحديث حالته
                $bookOffer = DB::table('book_offers')
                    ->where('user_id', $session->user_id)
                    ->where('offer_id', $session->service_id) // Assuming service_id corresponds to offer_id in sessions
                    ->where('date', $session->date)
                    ->where('time', $session->time)
                    ->first();

                if ($bookOffer) {
                    DB::table('book_offers')
                        ->where('id', $bookOffer->id)
                        ->update(['status' => 1, 'updated_at' => Carbon::now()]);
                }
            }

            return response()->json(['message' => 'Session approved successfully', 'session' => $session]);
        } else {
            return response()->json(['message' => 'Session cannot be approved'], 403);
        }
    }


    public function checkSession(Request $request, $id)
    {
        $session = Session::findOrFail($id);
        // التحقق من حالة الجلسة
        if ($session->status == 1) {
            // تغيير حالة الجلسة إلى موافق عليها
            $session->status = 2;
            $session->save();

            return response()->json(['message' => 'Session completed successfully', 'session' => $session]);
        } else {
            return response()->json(['message' => 'Session cannot be complet'], 403);
        }
    }




    public function getPendingSessions(Request $request)
    {
        $user = $request->user();
        $sessions = Session::where('user_id', $user->id)
            ->where('status', 0)
            ->with(['availableSlot' => function ($query) {
                $query->select('id', 'service_id');
            }])
            ->get();

        $sessionsWithService = $sessions->map(function ($session) {
            return [
                'id' => $session->id,
                'user_id' => $session->user_id,
                'available_slots_id' => $session->available_slots_id,
                'service_id' => $session->availableSlot->service_id ?? null,
                'service' => $session->service,
                'specialist' => $session->specialist,
                'date' => $session->date,
                'time' => $session->time,
                'status' => $session->status,
                'type' => $session->type,
                'created_at' => $session->created_at,
                'updated_at' => $session->updated_at,
            ];
        });

        return response()->json($sessionsWithService);
    }


    // تابع لإرجاع جميع الجلسات بحالة approved (status = 1)
    public function getApprovedSessions(Request $request)
    {
        $user = $request->user();
        $sessions = Session::where('user_id', $user->id)
            ->where('status', 1)
            ->with(['availableSlot' => function ($query) {
                $query->select('id', 'service_id');
            }])
            ->get();

        $sessionsWithService = $sessions->map(function ($session) {
            return [
                'id' => $session->id,
                'user_id' => $session->user_id,
                'available_slots_id' => $session->available_slots_id,
                'service_id' => $session->availableSlot->service_id ?? null,
                'service' => $session->service,
                'specialist' => $session->specialist,
                'date' => $session->date,
                'time' => $session->time,
                'status' => $session->status,
                'type' => $session->type,
                'created_at' => $session->created_at,
                'updated_at' => $session->updated_at,
            ];
        });

        return response()->json($sessionsWithService);
    }


    // تابع لإرجاع جميع الجلسات بحالة completed (status = 2)
    public function getCompletedSessions(Request $request)
    {
        $user = $request->user();

        // جلب الجلسات المكتملة مع المراجعات المرتبطة بها
        $sessions = Session::where('user_id', $user->id)
            ->where('status', 2)
            ->with('review') // تضمين العلاقة مع المراجعة
            ->get();

        return response()->json($sessions);
    }

    public function getRefusedSessions(Request $request)
    {
        $user = $request->user();
        $sessions = Session::where('user_id', $user->id)
            ->where('status', 3)
            ->get();
        return response()->json($sessions);
    }


    public function updateSession(Request $request, $id)
    {
        $session = Session::findOrFail($id);
        $user = $request->user();

        if ($session->user_id != $user->id) {
            return response()->json(['message' => 'You are not authorized to update this session'], 403);
        }

        if ($session->status == 0 || $session->status == 1) {
            $request->validate([
                'specialist_id' => 'nullable|integer|exists:specialists,id',
                'service_id' => 'nullable|integer|exists:services,id',
                'available_slots_id' => 'nullable|integer|exists:available_slots,id',
            ]);

            $specialistId = $request->input('specialist_id');
            $serviceId = $request->input('service_id');
            $availableSlotId = $request->input('available_slots_id');

            if ($availableSlotId) {
                $availableSlot = AvailableSlot::findOrFail($availableSlotId);

                if ($specialistId && $availableSlot->specialist_id != $specialistId) {
                    return response()->json(['message' => 'The specialist does not match the selected slot'], 400);
                }

                if ($availableSlot->is_booked) {
                    return response()->json(['message' => 'The selected slot is already booked'], 400);
                }
            }

            if ($specialistId && !$serviceId) {
                $serviceSpecialist = Service_Specialist::where('specialist_id', $specialistId)->exists();
                if (!$serviceSpecialist) {
                    return response()->json(['message' => 'The specialist is not linked to any service'], 404);
                }

                if (!$availableSlotId) {
                    return response()->json(['message' => 'available_slots_id is required when specialist_id is provided'], 400);
                }
            }

            if ($specialistId && $serviceId) {
                $serviceSpecialist = Service_Specialist::where('service_id', $serviceId)
                    ->where('specialist_id', $specialistId)
                    ->first();

                if (!$serviceSpecialist) {
                    return response()->json(['message' => 'No record found linking the service and specialist'], 404);
                }
            }

            if ($availableSlotId) {
                $session->date = $availableSlot->date;
                $session->time = $availableSlot->time;

                $oldAvailableSlotId = $session->available_slots_id;
                $session->available_slots_id = $availableSlot->id;

                $availableSlot->is_booked = true;
                $availableSlot->save();

                if ($oldAvailableSlotId) {
                    $oldAvailableSlot = AvailableSlot::findOrFail($oldAvailableSlotId);
                    $oldAvailableSlot->is_booked = false;
                    $oldAvailableSlot->save();
                }
            }

            if ($specialistId) {
                $specialist = Specialist::findOrFail($specialistId);
                $session->specialist = $specialist->name;
            }

            if ($serviceId) {
                $service = Service::findOrFail($serviceId);
                $session->service = $service->name;
            }

            $session->save();

            return response()->json('Session updated successfully');
        } else {
            return response()->json(['message' => 'Session cannot be updated'], 403);
        }
    }










    public function deleteSession(Request $request, $id)
    {
        $session = Session::findOrFail($id);
        $user = $request->user();
        $oldAvailableSlotId = $session->available_slots_id;

        if ($session->user_id != $user->id) {
            return response()->json(['message' => 'You are not authorized to delete this session'], 403);
        }

        if ($session->status == 0 || $session->status == 1) {
            $session->delete();
            if ($oldAvailableSlotId) {
                $oldAvailableSlot = AvailableSlot::findOrFail($oldAvailableSlotId);
                $oldAvailableSlot->is_booked = false;
                $oldAvailableSlot->save();
            }
            return response()->json(['message' => 'Session deleted successfully']);
        } else {
            return response()->json(['message' => 'Session cannot be deleted'], 403);
        }
    }
    public function getPendingSessionsForAdmin(Request $request)
    {

        $sessions = Session::where('status', 0)->get();
        return response()->json($sessions);
    }

    // تابع لإرجاع جميع الجلسات بحالة approved (status = 1)
    public function getApprovedSessionsForAdmin(Request $request)
    {
        $sessions = Session::where('status', 1)->get();
        return response()->json($sessions);
    }

    // تابع لإرجاع جميع الجلسات بحالة completed (status = 2)
    public function getCompletedSessionsForAdmin(Request $request)
    {

        // جلب الجلسات المكتملة مع المراجعات المرتبطة بها
        $sessions = Session::where('status', 2)
            ->with('review') // تضمين العلاقة مع المراجعة
            ->get();

        return response()->json($sessions);
    }

    public function getRefusedSessionsForAdmin(Request $request)
    {
        $sessions = Session::where('status', 3)
            ->get();
        return response()->json($sessions);
    }



}
