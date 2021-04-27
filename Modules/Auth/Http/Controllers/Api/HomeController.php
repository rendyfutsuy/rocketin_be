<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Return response message.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function index()
    {
        return response()->json(auth()->user());
    }
}
