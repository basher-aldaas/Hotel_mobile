<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(10);
        return view('galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $imageName = now()->format('Ymd_His') . '_' . uniqid() . '.' . $request->image->getClientOriginalExtension();

        // حفظ الصورة داخل public/gallery
        $request->image->move(public_path('gallery'), $imageName);

        $gallery = new Gallery();
        $gallery->image = 'gallery/' . $imageName;
        $gallery->save();

        return redirect()->route('galleries.index')->with('success', 'Gallery created successfully.');
    }

    public function show(Gallery $gallery)
    {
        return view('galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        return view('galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة من public/gallery
            $oldImagePath = public_path($gallery->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // رفع الصورة الجديدة
            $imageName = now()->format('Ymd_His') . '_' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('gallery'), $imageName);

            $gallery->image = 'gallery/' . $imageName;
        }

        $gallery->save();

        return redirect()->route('galleries.index')->with('success', 'Gallery updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        // حذف الصورة من public/gallery
        $imagePath = public_path($gallery->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $gallery->delete();

        return redirect()->route('galleries.index')->with('success', 'Gallery deleted successfully.');
    }
}
