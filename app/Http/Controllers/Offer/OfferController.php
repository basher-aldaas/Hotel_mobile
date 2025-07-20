<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offer\CreateOfferRequest;
use App\Http\Requests\Offer\UpdateOfferRequest;
use App\Http\Responses\Response;
use App\Services\Offer\OfferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    private OfferService $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    //function to create an offer
    public function create_offer(CreateOfferRequest $request , $room_id) :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->offerService->create_offer($request->validated() , $room_id);
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }

    //function to update an offer
    public function update_offer(UpdateOfferRequest $request , $id) :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->offerService->update_offer($request->validated() , $id);
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }

    //function to show offers for special room
    public function show_offers_room($room_id) :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->offerService->show_offers_room($room_id);
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }

    //function to all offers
    public function show_offers() :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->offerService->show_offers();
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }

    //function to delete special offer
    public function delete_offer($offer_id) :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->offerService->delete_offer($offer_id);
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }
}
