<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\CreateGalleryRequest;
use App\Http\Requests\Gallery\UpdateGalleryRequest;
use App\Http\Responses\Response;
use App\Models\Gallery;
use App\Services\Gallery\GalleryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    private GalleryService $galleryService;

    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
    }

    //function to add gallery
    public function create_gallery(CreateGalleryRequest $request) :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->galleryService->create_gallery($request->validated());
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }

    //function to update gallery
    public function update_gallery(UpdateGalleryRequest $request , $id) :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->galleryService->update_gallery($request->validated() , $id);
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }

    //function to show special gallery
    public function show_gallery($id) :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->galleryService->show_gallery($id);
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }

    //function to show all galleries
    public function show_galleries() :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->galleryService->show_galleries();
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }

    //function to delete special gallery
    public function delete_gallery($id) :JsonResponse
    {
        {
            $data = [];
            try {
                $data = $this->galleryService->delete_gallery($id);
                return Response::Success($data['data'] , $data['message'] , $data['code']);
            }catch (\Throwable $throwable){
                $message = $throwable->getMessage();
                return Response::Error($data , $message);
            }

        }
    }
}
