<?php

namespace App\Modules\Country;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Country\CountryService;
use App\Modules\Country\Resources\CountryResource;
use App\Modules\Country\Requests\CreateCountryRequest;
use App\Modules\Country\Requests\UpdateCountryRequest;
use Maatwebsite\Excel\Facades\Excel;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->middleware('auth')->except(['index', 'show','store']);
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
        $this->authorize('viewAny', Country::class);

        $countries = $this->countryService->paginate($request->all());
        return CountryResource::collection($countries);
    }

    /**
     * @OA\GET(
     *     path="/api/countries/{id}",
     *     tags={"Countries"},
     *     summary="Get Country detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $this->authorize('view', Country::class);

        $country = $this->countryService->getOneOrFail($id, $request->all());
        return new CountryResource($country);
    }

    /**
     * @OA\POST(
     *     path="/api/countries",
     *     tags={"Countries"},
     *     summary="Create a new Country",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(CreateCountryRequest $request)
    {
        $this->authorize('create', Country::class);

        $country = $this->countryService->createOne($request->all());
        return new CountryResource($country);
    }

    /**
     * @OA\PUT(
     *     path="/api/countries/{id}",
     *     tags={"Countries"},
     *     summary="Update an existing Country",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(UpdateCountryRequest $request, string $id)
    {
        // $this->authorize('update', Country::class);

        $country = $this->countryService->updateOne($id, $request->all());
        return new CountryResource($country);
    }

    /**
     * @OA\DELETE(
     *     path="/api/countries/{id}",
     *     tags={"Countries"},
     *     summary="Delete a Country",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        // $this->authorize('delete', Country::class);

        $country = $this->countryService->deleteOne($id);
        return new CountryResource($country);
    }

    /**
     * @OA\POST(
     *     path="/api/countries/{id}/restore",
     *     tags={"Countries"},
     *     summary="Restore a Country from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        // $this->authorize('restore', Country::class);

        $country = $this->countryService->restoreOne($id);
        return new CountryResource($country);
    }

    public function exports()
    {
        return Excel::download(new CountriesExport, 'countries.xlsx');
    }
}
