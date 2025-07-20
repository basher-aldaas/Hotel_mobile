<?php

namespace App\Services\Offer;

use App\Models\Offer;
use App\Models\Room;
use Illuminate\Support\Carbon;

class OfferService
{
    public function create_offer($request , $room_id) : array
    {
       $room = Room::find($room_id);

       if (!$room){
           return [
               'data' => null,
               'message' => 'Room not found',
               'code' => 404
           ];
       }

        $offer = Offer::create([
            'room_id' => $room_id,
            'title' => $request['title'],
            'description' => $request['description'],
            'discount' => $request['discount'],
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
        ]);

           return [
               'data' => $offer,
               'message' => 'Created offer successfully',
               'code' => 200
           ];
    }

    public function update_offer($request , $id) : array
    {
        $offer = Offer::find($id);

        if (!$offer){
            return [
                'data' => null,
                'message' => 'Offer not found',
                'code' => 404
            ];
        }

        $offer->update([
            'title' => $request['title'] ?? $offer->title,
            'description' => $request['description'] ?? $offer->description,
            'discount' => $request['discount'] ?? $offer->discount,
            'start_date' => $request['start_date'] ?? $offer->start_date,
            'end_date' => $request['end_date'] ?? $offer->end_date,
        ]);

        return [
            'data' => $offer,
            'message' => 'Updated offer successfully',
            'code' => 200
        ];
    }

    public function show_offers_room($room_id) : array
    {
        $offers = Offer::query()
            ->where('room_id', $room_id)
            ->where('end_date', '>', Carbon::today())
            ->get();

        if ($offers->isEmpty()) {
            return [
                'data' => [],
                'message' => 'Not found',
                'code' => 404
            ];
        }

        return [
            'data' => $offers,
            'message' => 'Getting offers successfully.',
            'code' => 200
        ];

    }

    public function show_offers() : array
    {
        $offers = Offer::where('end_date' , '>' , Carbon::today())->get();

        if ($offers){
            $data = $offers;
            $message = 'Getting all offers successfully';
            $code = 200;
        }

        return [
            'data' => $data ?? null,
            'message' => $message ?? 'Not found',
            'code' => $code ?? 404,
        ];
    }

    public function delete_offer($offer_id) : array
    {
        $offer = Offer::find($offer_id);
        if ($offer){
            $offer->delete();
            $message = 'Deleted offers successfully';
            $code = 200;
        }

        return [
            'data' => [],
            'message' => $message ?? 'Not found',
            'code' => $code ?? 404,
        ];
    }
}
