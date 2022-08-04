<?php

namespace App\Modules\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Agent\AgentService;
use App\Modules\Agent\Resources\AgentResource;

class AgentController extends Controller
{
    protected $agentService;

    public function __construct(AgentService $agentService)
    {
        $this->agentService = $agentService;
    }


    /**
     * @OA\GET(
     *     path="/api/agents",
     *     tags={"Agents"},
     *     summary="Get Agents list",
     *     description="Get Agents List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        $agents = $this->agentService->paginate($request->all());
        return AgentResource::collection($agents);
    }

    /**
     * @OA\GET(
     *     path="/api/agents/{id}",
     *     tags={"Agents"},
     *     summary="Get Agent detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, string $id)
    {
        $agent = $this->agentService->getOneOrFail($id, $request->all());
        return new AgentResource($agent);
    }
}
