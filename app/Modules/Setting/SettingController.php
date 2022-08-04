<?php

namespace App\Modules\Setting;

use App\Http\Controllers\Controller;
use App\Modules\Setting\Enum\Setting;
use Illuminate\Http\Request;
use App\Modules\Setting\SettingService;
use App\Modules\Setting\Resources\SettingResource;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->middleware('auth')->except(['getTheme']);
        $this->settingService = $settingService;
    }

    /**
     * @OA\GET(
     *     path="/api/settings",
     *     tags={"Settings"},
     *     summary="Get Settings list",
     *     description="Get Settings List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Setting::class);

        $settings = $this->settingService->getFromCache($request);
        return SettingResource::collection($settings);
    }

    /**
     * @OA\GET(
     *     path="/api/settings/theme",
     *     tags={"Settings"},
     *     summary="Get Website Theme",
     *     description="Get website theme",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function getTheme(Request $request)
    {
        return $this->settingService->getTheme($request);
    }

    /**
     * @OA\POST(
     *     path="/api/settings/theme",
     *     tags={"Settings"},
     *     summary="Update Theme",
     *     description="Update website theme",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateTheme(Request $request)
    {
        $this->authorize('update', Setting::class);

        return $this->settingService->saveTheme($request);
    }
}
