<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Admin\Http\Resources\SiteStaticDetail;

class ShowSiteStatic extends Controller
{
    public function __invoke(): JsonResponse
    {     
        return response()->json(SiteStaticDetail::render());
    }
}
