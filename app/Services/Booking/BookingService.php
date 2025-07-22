<?php

namespace App\Services\Booking;

use App\Models\Booking;
use App\Models\Offer;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function create_booking($request, $id): array
    {
        $room = Room::find($id);
        $user = Auth::user();

        if (!$room) {
            return [
                'data' => [],
                'message' => 'rooms not found',
                'code' => 404,
            ];
        }

        $booking_status = Booking::where('room_id', $id)
            ->where('status', 0)
            ->first();

        if ($booking_status) {
            return [
                'data' => [],
                'message' => 'This room is already booked until: ' . Carbon::parse($booking_status->end_date)->addDay()->toDateString(),
                'code' => 400,
            ];
        }

        // حساب السعر بعد النظر في العروض
        $today = Carbon::today();
        $offer = Offer::where('room_id', $id)
            ->where('end_date', '>=', $today)
            ->first();

        $originalPrice = $room->price;
        $finalPrice = $originalPrice;

        if ($offer) {
            $finalPrice = $originalPrice - ($originalPrice * ($offer->discount / 100));
        }

        $wantsToPayNow = $request['payment_status'] == 1;
        $amount = $wantsToPayNow ? $finalPrice : 0;

        if ($user->wallet < $amount) {
            return [
                'data' => [],
                'message' => 'You do not have enough money',
                'code' => 402,
            ];
        }

        return DB::transaction(function () use ($request, $user, $id, $amount, $wantsToPayNow, $finalPrice) {
            $user->wallet -= $amount;
            $user->save();

            $booking = Booking::create([
                'user_id' => $user->id,
                'room_id' => $id,
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date'],
                'payment_status' => $wantsToPayNow ? 1 : 0,
                'guests_count' => $request['guests_count'],
                'final_price' => $finalPrice,
            ]);

            return [
                'data' => $booking,
                'message' => 'Booking created' . ($wantsToPayNow ? ' and payment deducted' : '') . ' successfully',
                'code' => 200,
            ];
        });
    }


    public function update_booking($request, $id): array
    {
        $booking = Booking::find($id);
        $user_id = $booking->user_id;
        if (Auth::id() == $user_id){
            if (!$booking) {
                return [
                    'data' => [],
                    'message' => 'Booking not found',
                    'code' => 404,
                ];
            }

            // الفرق بين اليوم وتاريخ البدء ≤ 1 ⇒ لا نسمح بالتعديل
            $daysDifference = Carbon::today()->diffInDays(Carbon::parse($booking->start_date), false);
            if ($daysDifference <= 1) {
                return [
                    'data' => [],
                    'message' => 'You can no longer edit this booking. It must be updated at least 2 days before start date.',
                    'code' => 403,
                ];
            }

            // الحجز يمكن تعديله
            $booking->update([
                'start_date' => $request['start_date'] ?? $booking->start_date,
                'end_date' => $request['end_date'] ?? $booking->end_date,
                'guests_count' => $request['guests_count'] ?? $booking->guests_count,
            ]);

            return [
                'data' => $booking,
                'message' => 'Booking updated successfully.',
                'code' => 200,
            ];
        }else{
            return [
                'data' => [],
                'message' => 'This booking does not belongs to you to update it',
                'code' => 403,
            ];
        }
    }

    public function delete_booking($id): array
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return [
                'data' => [],
                'message' => 'Booking not found',
                'code' => 404,
            ];
        }

        if (Auth::id() !== $booking->user_id) {
            return [
                'data' => [],
                'message' => 'This booking does not belong to you to delete it',
                'code' => 403,
            ];
        }

        // التحقق من عدد الأيام المتبقية
        $daysDifference = Carbon::today()->diffInDays(Carbon::parse($booking->start_date), false);
        if ($daysDifference <= 1) {
            return [
                'data' => [],
                'message' => 'You can no longer delete this booking. It must be deleted at least 2 days before start date.',
                'code' => 403,
            ];
        }

        return DB::transaction(function () use ($booking) {
            $user = User::find($booking->user_id);
            $room = Room::find($booking->room_id);

            // استرجاع المبلغ إذا كان مدفوعًا
            if ($booking->payment_status == 1 && $user) {
                $user->wallet += $booking->final_price; // استخدام final_price
                $user->save();
            }

            // تعديل حالة الحجز للغرفة لتكون متاحة (اختياري حسب منطقك)
            if ($room) {
                $room->status = 1;
                $room->save();
            }

            // حذف الحجز
            $booking->delete();

            return [
                'data' => [],
                'message' => 'Booking deleted successfully and payment refunded.',
                'code' => 200,
            ];
        });
    }

    public function show_room_bookings($id): array
    {
        $room = Room::find($id);
        if (!$room) {
            return [
                'data' => [],
                'message' => 'This room not found',
                'code' => 404
            ];
        }

        $bookings = Booking::where('room_id', $id)
            ->select('start_date', 'end_date', 'final_price')
            ->orderBy('start_date')
            ->get();

        if ($bookings->isEmpty()) {
            return [
                'data' => [],
                'message' => 'This room does not have any bookings',
                'code' => 404
            ];
        }

        return [
            'data' => $bookings,
            'message' => 'Getting all bookings successfully',
            'code' => 200
        ];
    }

    public function show_all_my_bookings() : array
    {
        $bookings = Booking::with('room')
            ->where('user_id', Auth::id())
            ->orderBy('start_date')
            ->get();

       if ($bookings->isNotEmpty()){
           $data = $bookings;
           $message = 'There is all your bookings';
           $code = 200;
       }
        return [
            'data' => $data ?? [],
            'message' => $message ?? 'There is no bookings',
            'code' => $code ?? 404,
        ];

    }

    public function show_all_bookings() : array
    {
        $bookings = Booking::with('room')
            ->where('status', 0)
            ->orderBy('start_date')
            ->get();        if ($bookings->isNotEmpty()){
            $data = $bookings;
            $message = 'This is all bookings ';
            $code = 200;
        }

        return [
            'data' => $data ?? null,
            'message' => $message ?? 'Not found',
            'code' => $code ?? 404,
        ];
    }

}
