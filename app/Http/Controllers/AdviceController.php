<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use Illuminate\Http\Request;

class AdviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adviceList = Advice::all();

        return response()->json(['adviceList' => $adviceList], 200);
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
            'advice' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480', // الصور والفيديوهات بحد أقصى 20 ميجابايت
        ]);

        $adviceData = [];

        if ($advice = $request->input('advice')) {
            $adviceData['advice'] = $advice;
        }

        if ($media = $request->file('media')) {
            $mediaName = time() . '_' . $media->getClientOriginalName();
            $mediaPath = $media->storeAs('uploads', $mediaName, 'public');
            $adviceData['media'] = $mediaPath;
            $adviceData['media_type'] = $media->getClientMimeType();
        }

        $advice = Advice::create($adviceData);

        return response()->json(['advice' => $advice], 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advice  $advice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     $advice=Advice::findOrFail($id);
     return response()->json($advice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advice  $advice
     * @return \Illuminate\Http\Response
     */
    public function edit(Advice $advice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advice  $advice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $advice = Advice::findOrFail($id);

        $request->validate([
            'advice' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480', // الصور والفيديوهات بحد أقصى 20 ميجابايت
        ]);

        if ($adviceText = $request->input('advice')) {
            $advice->advice = $adviceText;
        }

        if ($media = $request->file('media')) {
            $mediaName = time() . '_' . $media->getClientOriginalName();
            $mediaPath = $media->storeAs('uploads', $mediaName, 'public');
            $advice->media = $mediaPath;
            $advice->media_type = $media->getClientMimeType();
        }

        $advice->save();

        return response()->json(['advice' => $advice], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advice  $advice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advice = Advice::findOrFail($id);
        $advice->delete();

        return response()->json(['message' => 'Advice deleted successfully'], 200);
    }

}
