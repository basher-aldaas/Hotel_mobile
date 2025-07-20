<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\AddRatingRoomRequest;
use App\Http\Requests\Room\CreateRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Http\Responses\Response;
use App\Services\Room\RoomService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    private RoomService $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    //function to create a room
    public function create_room(CreateRoomRequest $request) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->roomService->create_room($request->validated());
            return Response::Success($data['data'] , $data['message']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to update a room
    public function update_room(UpdateRoomRequest $request , $id) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->roomService->update_room($request->validated() , $id);
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to delete a room
    public function delete_room($id) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->roomService->delete_room($id);
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to show special room
    public function show_room($id) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->roomService->show_room($id);
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to show rooms
    public function show_rooms() : JsonResponse
    {
        $data = [];
        try {
            $data = $this->roomService->show_rooms();
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to add rating to a special room
    public function add_rating(AddRatingRoomRequest $request , $id) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->roomService->add_rating($request->validated() , $id);
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to get room ratings
    public function get_room_average_rating($id) : JsonResponse
    {
        $data = [];
        try {
            $data = $this->roomService->get_room_average_rating($id);
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }

    //function to get all room not booking
    public function get_all_room_not_booking() : JsonResponse
    {
        $data = [];
        try {
            $data = $this->roomService->get_all_room_not_booking();
            return Response::Success($data['data'] , $data['message'] , $data['code']);
        }catch (\Throwable $throwable){
            $message = $throwable->getMessage();
            return Response::Error($data , $message);
        }

    }
}
