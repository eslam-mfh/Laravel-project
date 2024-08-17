<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $media = Media::all();
        return response()->json($media);
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
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $media = Media::findOrFail($id);
        return response()->json($media);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $media = Media::findOrFail($id);

        $request->validate([
            'file_1' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_2' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $mediaData = [];

        if ($file_1 = $request->file('file_1')) {
            $filePath_1 = $file_1->store('uploads', 'public');
            $mediaData['file_name_1'] = $file_1->getClientOriginalName();
            $mediaData['file_path_1'] = $filePath_1;
            $mediaData['file_type_1'] = $this->getFileType($file_1);
            $mediaData['mime_type_1'] = $file_1->getMimeType();
            $mediaData['file_size_1'] = $file_1->getSize();
        }

        if ($file_2 = $request->file('file_2')) {
            $filePath_2 = $file_2->store('uploads', 'public');
            $mediaData['file_name_2'] = $file_2->getClientOriginalName();
            $mediaData['file_path_2'] = $filePath_2;
            $mediaData['file_type_2'] = $this->getFileType($file_2);
            $mediaData['mime_type_2'] = $file_2->getMimeType();
            $mediaData['file_size_2'] = $file_2->getSize();
        }

        if (!empty($mediaData)) {
            $media->update($mediaData);
            return response()->json(['media' => $media], 200);
        }

        return response()->json(['error' => 'Update failed'], 400);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        $media->delete();
        return response()->json(['message' => 'Media deleted successfully'], 200);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file_1' => 'required|mimes:jpeg,png,jpg,gif,mp4,avi,mov,wmv|max:204800',
            'file_2' => 'mimes:jpeg,png,jpg,gif,mp4,avi,mov,wmv|max:204800',
        ]);

        $mediaData = [];

        if ($file_1 = $request->file('file_1')) {
            $filePath_1 = $file_1->store('uploads', 'public');
            $mediaData['file_name_1'] = $file_1->getClientOriginalName();
            $mediaData['file_path_1'] = $filePath_1;
            $mediaData['file_type_1'] = $this->getFileType($file_1);
            $mediaData['mime_type_1'] = $file_1->getMimeType();
            $mediaData['file_size_1'] = $file_1->getSize();
        }

        if ($file_2 = $request->file('file_2')) {
            $filePath_2 = $file_2->store('uploads', 'public');
            $mediaData['file_name_2'] = $file_2->getClientOriginalName();
            $mediaData['file_path_2'] = $filePath_2;
            $mediaData['file_type_2'] = $this->getFileType($file_2);
            $mediaData['mime_type_2'] = $file_2->getMimeType();
            $mediaData['file_size_2'] = $file_2->getSize();
        }

        if (!empty($mediaData)) {
            $media = Media::create($mediaData);
            return response()->json(['media' => $media], 201);
        }

        return response()->json(['error' => 'File upload failed'], 400);
    }

    private function getFileType($file)
    {
        $mimeType = $file->getMimeType();
        if (strstr($mimeType, "video/")) {
            return 'video';
        } elseif (strstr($mimeType, "image/")) {
            return 'image';
        }

        return 'unknown';
    }

}
