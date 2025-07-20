<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\CreateBookingRequest;
use App\Http\Requests\Booking\UpdateBookingRequest;
use App\Http\Responses\Response;
use App\Services\Booking\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    //function to create booking
    public function create_booking(CreateBookingRequest $request , $id) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->bookingService->create_booking($request->validated() , $id);
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to update booking
    public function update_booking(UpdateBookingRequest $request , $id) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->bookingService->update_booking($request->validated() , $id);
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to update delete
    public function delete_booking($id) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->bookingService->delete_booking($id);
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to show bookings plan for special room
    public function show_room_bookings($id) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->bookingService->show_room_bookings($id);
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to show all my bookings the old and new one
    public function show_all_my_bookings() : JsonResponse
    {
        $data = [];
        try {
            $data = $this->bookingService->show_all_my_bookings();
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to show all  bookings
    public function show_all_bookings() : JsonResponse
    {
        $data = [];
        try {
            $data = $this->bookingService->show_all_bookings();
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }


}
