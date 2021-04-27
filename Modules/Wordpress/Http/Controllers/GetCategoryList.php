<?php

namespace Modules\Wordpress\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Wordpress\ServiceManager\Wordpress;
use Modules\Wordpress\Http\Resources\CategoryCollection;

class GetCategoryList extends Controller
{
    /** @var Wordpress */
    protected $wordpress;

    public function __construct(Wordpress $wordpress)
    {
        $this->wordpress = $wordpress;
    }

    public function __invoke(Request $request)
    {
        $responses = $this->wordpress->categories([
            'search' => $request->search,
            'per_page' => $request->per_page ?? 100,
            'page' => $request->page ?? 1,
            'parent' => $request->parent ?? null,
            'include' => $request->include ?? [],
        ]);

        return new CategoryCollection($responses);
    }
}