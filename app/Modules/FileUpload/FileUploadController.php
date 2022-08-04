<?php

namespace App\Modules\FileUpload;

use App\Http\Controllers\Controller;
use App\Modules\FileUpload\FileUploadService;
use App\Modules\FileUpload\Requests\DocumentUploadRequest;
use App\Modules\FileUpload\Requests\ImageUploadRequest;
use App\Modules\FileUpload\Requests\MultiDocumentUploadRequest;
use App\Modules\FileUpload\Requests\MultiImageUploadRequest;
use App\Modules\FileUpload\Resources\FileUploadResource;

class FileUploadController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->middleware('auth');
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @OA\POST(
     *     path="/api/uploads/image",
     *     tags={"File Uploads"},
     *     summary="Upload one or multiple images",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function uploadImage(ImageUploadRequest $request)
    {
        $result = $this->fileUploadService->uploadTemporaryFile(
            $request->file('image'),
            $request->input('directory', 'images')
        );

        return new FileUploadResource($result);
    }

    /**
     * @OA\POST(
     *     path="/api/uploads/images",
     *     tags={"File Uploads"},
     *     summary="Upload one or multiple images",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function uploadMultiImages(MultiImageUploadRequest $request)
    {
        $paths = $this->fileUploadService->uploadTemporaryFiles(
            $request->file('images'),
            $request->input('directory', 'images')
        );

        return FileUploadResource::collection($paths);
    }

    /**
     * @OA\POST(
     *     path="/api/uploads/document",
     *     tags={"File Uploads"},
     *     summary="Upload one or multiple documents",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function uploadDocument(DocumentUploadRequest $request)
    {
        $result = $this->fileUploadService->uploadTemporaryFile(
            $request->file('document'),
            $request->input('directory', 'documents')
        );

        return new FileUploadResource($result);
    }

    /**
     * @OA\POST(
     *     path="/api/uploads/documents",
     *     tags={"File Uploads"},
     *     summary="Upload one or multiple documents",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function uploadMultiDocuments(MultiDocumentUploadRequest $request)
    {
        $paths = $this->fileUploadService->uploadTemporaryFiles(
            $request->file('documents'),
            $request->input('directory', 'documents')
        );

        return FileUploadResource::collection($paths);
    }
}
