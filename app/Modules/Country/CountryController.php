<?php

namespace App\Modules\Country;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Country\CountryService;
use App\Modules\Country\Exports\CountriesExport;
use App\Modules\Country\Resources\CountryResource;
use App\Modules\Country\Requests\CreateCountryRequest;
use App\Modules\Country\Requests\UpdateCountryRequest;
use Maatwebsite\Excel\Facades\Excel;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->countryService = $countryService;
    }

    /**
     * @OA\GET(
     *     path="/api/countries",
     *     tags={"Countries"},
     *     summary="Get Countries list",
     *     description="Get Countries List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $countries = $this->countryService->paginate($request->all());
        return CountryResource::collection($countries);
    }

    /**
     * @OA\POST(
     *     path="/api/countries",
     *     tags={"Countries"},
     *     summary="Create a new Country",
     *     description="Create a new Country",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateCountryRequest $request)
    {
        $countries = $this->countryService->createOne($request->all());
        return new CountryResource($countries);
    }

    /**
     * @OA\GET(
     *     path="/api/countries/{id}",
     *     tags={"Countries"},
     *     summary="Get countries detail",
     *     description="Get countries detail by ID",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $countries = $this->countryService->getOneOrFail($id, $request->all());
        return new CountryResource($countries);
    }

    /**
     * @OA\PUT(
     *     path="/api/countries/{id}",
     *     tags={"Countries"},
     *     summary="Update an existing Country",
     *     description="Update an existing Country",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateCountryRequest $request, string $id)
    {
        $countries = $this->countryService->updateOne($id, $request->all());
        return new CountryResource($countries);
    }

    /**
     * @OA\DELETE(
     *     path="/api/countries/{id}",
     *     tags={"Countries"},
     *     summary="Delete a Country",
     *     description="Delete a Country",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(string $id)
    {
        $countries = $this->countryService->deleteOne($id);
        return new CountryResource($countries);
    }

    /**
     * @OA\POST(
     *     path="/api/countries/exports",
     *     tags={"Countries"},
     *     summary="Export countries to excel",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function exports()
    {
        return Excel::download(new CountriesExport, 'countries.xlsx');
    }
}
