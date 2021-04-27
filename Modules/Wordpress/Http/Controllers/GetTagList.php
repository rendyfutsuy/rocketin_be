<?php

namespace Modules\Wordpress\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Wordpress\ServiceManager\Wordpress;
use Modules\Wordpress\Http\Resources\TagCollection;

class GetTagList extends Controller
{
    /** @var Wordpress */
    protected $wordpress;

    public function __construct(Wordpress $wordpress)
    {
        $this->wordpress = $wordpress;
    }

    public function __invoke(Request $request)
    {
        $responses = $this->wordpress->tags([
            'search' => $request->search,
            'per_page' => 100,
        ]);
        
        return new TagCollection($responses);
    }
}