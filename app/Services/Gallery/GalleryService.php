<?php

namespace App\Services\Gallery;

use App\Models\Gallery;
use Illuminate\Support\Str;

class GalleryService
{

    public function create_gallery($request) : array
    {
        $image = $request['image'];
        $imageName = now()->format('Ymd_His') . '_' . Str::random(6) . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/galleries' , $imageName);

        $gallery = Gallery::create([
            'image' => 'storage/galleries' . $imageName,
        ]);

        return [
            'data' => $gallery,
            'message' => 'Gallery created successfully',
            'code' => 200,
        ];
    }

    public function update_gallery($request , $id) : array
    {
        $gallery = Gallery::query()->find($id);

        if ($gallery){
            if (isset($request['image']) && $request['image'] !== null) {
                $image = $request['image'];
                $imageName = now()->format('Ymd_His') . '_' . Str::random(6) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/galleries', $imageName);
                $imagePath = 'storage/galleries/' . $imageName;
            } else {
                $imagePath = $gallery->image; // احتفظ بالصورة القديمة
            }

            $gallery->update([
                'image'       => $imagePath,
            ]);

            $message = 'Gallery updated successfully';
            $code = 200;
        }

        return [
            'data' => $gallery ?? null,
            'message' => $message ?? 'Not found',
            'code' => $code ?? 404
        ];
    }

    public function show_gallery($id) : array
    {
        $gallery = Gallery::find($id);
        if ($gallery){
            $data = $gallery;
            $message = 'This is the gallery';
            $code = 200;
        }
        return [
            'data' => $data ?? null,
            'message' => $message ?? 'Not found',
            'code' => $code ?? 404,
        ];
    }

    public function show_galleries() : array
    {
        $galleries = Gallery::all();
        if ($galleries->isNotEmpty()){
            $data = $galleries;
            $message = 'This is all galleries';
            $code = 200;
        }
        return [
            'data' => $data ?? null,
            'message' => $message ?? 'Not found',
            'code' => $code ?? 404,
        ];
    }

    public function delete_gallery($id) : array
    {
        $gallery = Gallery::find($id);
        if ($gallery){
            $gallery->delete();
            $message = 'Gallery deleted successfully';
            $code = 200;
        }
        return [
            'data' => null,
            'message' => $message ?? 'Not found',
            'code' => $code ?? 404,
        ];
    }
}
