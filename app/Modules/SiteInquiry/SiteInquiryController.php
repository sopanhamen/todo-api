<?php

namespace App\Modules\SiteInquiry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\SiteInquiry\SiteInquiryService;
use App\Modules\SiteInquiry\Resources\SiteInquiryResource;
use App\Modules\SiteInquiry\Requests\CreateSiteInquiryRequest;
use App\Modules\SiteInquiry\Requests\UpdateSiteInquiryRequest;
use App\Modules\SiteInquiry\Resources\SiteInquiryListResource;

class SiteInquiryController extends Controller
{
    protected $siteInquiryService;

    public function __construct(SiteInquiryService $siteInquiryService)
    {
        $this->siteInquiryService = $siteInquiryService;
    }

    /**
     * @OA\GET(
     *     path="/api/site-inquiries",
     *     tags={"Site Inquiries"},
     *     summary="Get Site Inquiries list",
     *     description="Get Site Inquiries List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', SiteInquiry::class);

        $siteInquiries = $this->siteInquiryService->paginate($request->all());
        return SiteInquiryListResource::collection($siteInquiries);
    }

    /**
     * @OA\GET(
     *     path="/api/site-inquiries/{id}",
     *     tags={"Site Inquiries"},
     *     summary="Get Site Inquiry detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $siteInquiry = $this->siteInquiryService->getOneOrFail($id, $request->all());

        $this->authorize('view', $siteInquiry);

        return new SiteInquiryResource($siteInquiry);
    }

    /**
     * @OA\POST(
     *     path="/api/site-inquiries",
     *     tags={"Site Inquiries"},
     *     summary="Create a new Site Inquiry",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateSiteInquiryRequest $request)
    {
        $siteInquiry = $this->siteInquiryService->createOne($request->all());
        return new SiteInquiryResource($siteInquiry);
    }

    /**
     * @OA\PUT(
     *     path="/api/site-inquiries/{id}",
     *     tags={"Site Inquiries"},
     *     summary="Update an existing Site Inquiry",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateSiteInquiryRequest $request, string $id)
    {
        $this->authorize('update', SiteInquiry::class);

        $siteInquiry = $this->siteInquiryService->updateOne($id, $request->all());
        return new SiteInquiryResource($siteInquiry);
    }

    /**
     * @OA\DELETE(
     *     path="/api/site-inquiries/{id}",
     *     tags={"Site Inquiries"},
     *     summary="Delete a Site Inquiry",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', SiteInquiry::class);

        $siteInquiry = $this->siteInquiryService->deleteOne($id);
        return new SiteInquiryResource($siteInquiry);
    }

    /**
     * @OA\POST(
     *     path="/api/site-inquiries/{id}/restore",
     *     tags={"Site Inquiries"},
     *     summary="Restore a Site Inquiry from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(string $id)
    {
        $this->authorize('restore', SiteInquiry::class);

        $siteInquiry = $this->siteInquiryService->restoreOne($id);
        return new SiteInquiryResource($siteInquiry);
    }
}
