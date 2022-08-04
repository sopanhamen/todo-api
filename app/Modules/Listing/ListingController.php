<?php

namespace App\Modules\Listing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Listing\ListingService;
use App\Modules\Listing\Resources\ListingDetailResource;
use App\Modules\Listing\Resources\ListingResource;
use App\Modules\Listing\Resources\ListingSummaryResource;

class ListingController extends Controller
{
    protected $listingService;

    public function __construct(ListingService $listingService)
    {
        $this->listingService = $listingService;
    }

    /**
     * @OA\GET(
     *     path="/api/listings",
     *     tags={"Listings"},
     *     summary="Get Listings list",
     *     description="Get Listings List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $listings = $this->listingService->paginate($request->all());
        return ListingResource::collection($listings);
    }

    /**
     * @OA\GET(
     *     path="/api/listings/{id}",
     *     tags={"Listings"},
     *     summary="Get Listing detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $listing = $this->listingService->getOneOrFail($id, $request->all());
        return new ListingDetailResource($listing);
    }

    /**
     * @OA\GET(
     *     path="/api/listings/summaries",
     *     tags={"Listings"},
     *     summary="Get listing summaries detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function summarize(Request $request)
    {
        $summary = $this->listingService->getSummaries($request->limit ?? 2);
        return new ListingSummaryResource($summary);
    }
}
