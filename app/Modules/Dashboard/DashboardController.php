<?php

namespace App\Modules\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Dashboard\DashboardService;

class DashboardController extends Controller
{
    private DashboardService $service;

    public function __construct(DashboardService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    /**
     * @OA\GET(
     *     path="/api/dashboards",
     *     tags={"Dashboard"},
     *     summary="Get some information to display on the dashboard",
     *     description="Get information as Object",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        return response()->json($this->service->getDashboardData($request));
    }
}
