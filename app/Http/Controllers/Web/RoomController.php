<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
public function index()
{
$rooms = Room::latest()->paginate(10);
return view('rooms.index', compact('rooms'));
}

public function create()
{
return view('rooms.create');
}

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'wifi' => ['required', 'boolean'],
            'room_type' => ['required', 'in:regular,premium,deluxe'],
            'status' => ['nullable', 'boolean'],
            'bed_number' => ['required', 'integer', 'min:1'],
        ]);

        // معالجة الصورة وتخزينها في public/rooms
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'room' . now()->format('Ymd_His') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('room'), $imageName);
            $validatedData['image'] = 'room/' . $imageName; // حفظ المسار في قاعدة البيانات
        }

        Room::create($validatedData);

        return redirect()->route('rooms.index')->with('success', 'rooms created successfully.');
    }


public function show(Room $room)
{
return view('rooms.show', compact('room'));
}

public function edit(Room $room)
{
return view('rooms.edit', compact('room'));
}

    public function update(Request $request, Room $room)
    {
        $validatedData = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'wifi' => ['nullable', 'boolean'],
            'room_type' => ['nullable', 'in:regular,premium,deluxe'],
            'status' => ['nullable', 'boolean'],
            'bed_number' => ['nullable', 'integer', 'min:1'],
        ]);

        // إذا تم رفع صورة جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إن وُجدت
            if ($room->image && file_exists(public_path($room->image))) {
                unlink(public_path($room->image));
            }

            // رفع الصورة الجديدة بنفس النمط
            $image = $request->file('image');
            $imageName = 'room' . now()->format('Ymd_His') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('room'), $imageName);
            $validatedData['image'] = 'room/' . $imageName;
        }

        // تحديث بيانات الغرفة
        $room->update($validatedData);

        return redirect()->route('rooms.index')->with('success', 'rooms updated successfully.');
    }


public function destroy(Room $room)
{
$room->delete();
return redirect()->route('rooms.index')->with('success', 'rooms deleted successfully.');
}

    public function bookings($roomId)
    {
        // جلب الغرفة مع الحجوزات المرتبطة بها (يمكنك استخدام علاقة bookings في موديل Room)
        $room = Room::with('bookings.user')->find($roomId);

        if (!$room) {
            return redirect()->route('rooms.index')->with('error', 'Room not found.');
        }

        // عرض صفحة الحجوزات مع بيانات الغرفة والحجوزات
        return view('rooms.bookings', compact('room'));
    }

}
