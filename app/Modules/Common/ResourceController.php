<?php

namespace App\Modules\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    private $service;

    public function __construct(ResourceService $service)
    {
        $this->service = $service;
    }

    public function staticResource()
    {
        $resources = $this->service->getStaticResources();
        return response()->json($resources);
    }

    public function dynamicResources(Request $request)
    {
        $resources = $this->service->getDynamicResources($request->get('resources'));
        return response()->json($resources);
    }
}
