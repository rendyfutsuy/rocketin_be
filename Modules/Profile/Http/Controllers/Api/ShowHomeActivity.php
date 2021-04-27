<?php

namespace Modules\Profile\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Profile\Http\Resources\HomePage;

class ShowHomeActivity extends Controller
{
    public function __invoke(): JsonResponse
    {
        $home = new HomePage(auth('api')->user());
        
        return response()->json($home->render());
    }
}
