<?php

namespace App\Services\Gallery;

use App\Models\Gallery;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class GalleryService
{

    public function create_gallery($request): array
    {
        $image = $request['image'];
        $imageName = 'gallery_' . now()->format('Ymd_His') . '_' . Str::random(6) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('gallery'), $imageName);

        $gallery = Gallery::create([
            'image' => 'gallery/' . $imageName,
        ]);

        return [
            'data' => $gallery,
            'message' => 'Gallery created successfully',
            'code' => 200,
        ];
    }


    public function update_gallery($request, $id): array
    {
        $gallery = Gallery::query()->find($id);

        if (!$gallery) {
            return [
                'data' => null,
                'message' => 'Gallery not found',
                'code' => 404,
            ];
        }

        if (isset($request['image']) && $request['image'] !== null) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($gallery->image && File::exists(public_path($gallery->image))) {
                File::delete(public_path($gallery->image));
            }

            $image = $request['image'];
            $imageName = 'gallery_' . now()->format('Ymd_His') . '_' . Str::random(6) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('gallery'), $imageName);
            $imagePath = 'gallery/' . $imageName;
        } else {
            $imagePath = $gallery->image; // الاحتفاظ بالصورة القديمة
        }

        $gallery->update([
            'image' => $imagePath,
        ]);

        return [
            'data' => $gallery,
            'message' => 'Gallery updated successfully',
            'code' => 200,
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
