<?php

namespace Modules\Wordpress\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Wordpress\ServiceManager\Wordpress;

class StoreCategory extends Controller
{
    /** @var Wordpress */
    protected $wordpress;

    public function __construct(Wordpress $wordpress)
    {
        $this->wordpress = $wordpress;
    }

    public function __invoke(Request $request)
    {   
        return DB::transaction(function () use ($request) {
            $responses = $this->wordpress->request('post', $this->wordpress->baseUrl(). '/wp/v2/categories', [
                'description' => $request->description,
                'name' => $request->name,
                'slug' => $request->slug,
                'parent' => $request->parent,
                'met' => $request->met,
            ]);

            return response()->json([
                'message' => __('wordpress:crud.success'),
                'data' => [
                    'id' => $responses->id,
                    'name' => $responses->name,
                    'parent' => $responses->parent,
                    'link' => $responses->link,
                ],
            ]);
        });
    }
}