<?php

namespace App\Services\Room;

use App\Models\Booking;
use App\Models\Rating;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RoomService
{
    public function create_room($request) : array
    {

                $image = $request['image'];
                $imageName = now()->format('Ymd_His') . '_' . Str::random(6) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/rooms', $imageName);

                $room = Room::query()->create([
                    'title' => $request['title'],
                    'image' => 'storage/rooms/' . $imageName,
                    'description' => $request['description'],
                    'price' => $request['price'],
                    'wifi' => $request['wifi'],
                    'room_type' => $request['room_type'],
                    'status' => $request['status'] ?? null,
                    'bed_number' => $request['bed_number'],
                    'valuation' => $request['valuation'] ?? null,
                ]);


        return [
            'data' => $room,
            'message' => 'Room created successfully',
        ];

    }

    public function update_room($request, $id): array
    {
        $room = Room::query()->find($id);

        if ($room){
        // التحقق من وجود صورة جديدة في الطلب
        if (isset($request['image']) && $request['image'] !== null) {
            $image = $request['image'];
            $imageName = now()->format('Ymd_His') . '_' . Str::random(6) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/rooms', $imageName);
            $imagePath = 'storage/rooms/' . $imageName;
        } else {
            $imagePath = $room->image; // احتفظ بالصورة القديمة
        }

        $room->update([
            'title'       => $request['title'] ?? $room->title,
            'image'       => $imagePath,
            'description' => $request['description'] ?? $room->description,
            'price'       => $request['price'] ?? $room->price,
            'wifi'        => $request['wifi'] ?? $room->wifi,
            'room_type'   => $request['room_type'] ?? $room->room_type,
            'status'      => $request['status'] ?? $room->status,
            'bed_number'  => $request['bed_number'] ?? $room->bed_number,
            'valuation'   => $request['valuation'] ?? $room->valuation,
        ]);

        $message = 'Room updated successfully';
        $code = 200;
        }

        return [
            'data' => $room ?? null,
            'message' => $message ?? 'This room does not exists',
            'code' => $code ?? 404
        ];
    }

    public function delete_room($id) : array
    {
        $room = Room::find($id);
        if ($room) {
            $room->delete();
            $message = 'Deleted successfully';
            $code = 200;
        }
        return [
            'data' => [],
            'message' => $message ?? 'This room does not exists',
            'code' => $code ?? 404,
        ];
    }

    public function show_room($id) : array
    {
        $room = Room::query()->find($id);
        if ($room){
            $data = $room;
            $message = 'This is the room';
            $code = 200;
        }
        return [
            'data' => $data ?? [],
            'message' => $message ?? 'This room does not exists',
            'code' => $code ?? 404,
        ];
    }

    public function show_rooms() : array
    {
        $rooms = Room::all();
        if ($rooms->isNotEmpty()){
            $data = $rooms;
            $message = 'This is all rooms';
            $code = 200;
        }
        return [
            'data' => $data ?? [],
            'message' => $message ?? 'There is no rooms',
            'code' => $code ?? 404,
        ];
    }

    public function add_rating($request , $id): array
    {
        $user = Auth::user();

        $room = Room::find($id);
        if (!$room){
            return [
                'data' => [],
                'message' => 'This Room does not exists',
                'code' => 404
            ];
        }

        $rating = Rating::create([
            'user_id' => $user->id,
            'room_id' => $id,
            'rating' => $request['rating'],
            'comment' => $request['comment'] ?? null,
        ]);

        return [
            'data' => $rating,
            'message' => 'Rating added successfully.',
            'code' => 200,
        ];
    }

    public function get_room_average_rating($id): array
    {
        $room = Room::find($id);
        if (!$room){
            return [
                'data' => [],
                'message' => 'This Room does not exists',
                'code' => 404
            ];
        }
        $average = Rating::where('room_id', $id)->avg('rating');

        return [
            'data' => ['average_rating' => round($average, 2)],
            'message' => 'Average rating retrieved successfully.',
            'code' => 200,
        ];
    }


    public function get_all_room_not_booking(): array
    {
        $rooms = Room::whereDoesntHave('bookings', function ($query) {
            $query->where('status', 0);
        })->with('bookings')->get();

        if ($rooms->isNotEmpty()) {
            return [
                'data' => $rooms,
                'message' => 'Rooms that are currently not booked.',
                'code' => 200,
            ];
        }

        return [
            'data' => [],
            'message' => 'No unbooked rooms found.',
            'code' => 404,
        ];
    }





}
