<?php

namespace Theme\Stories\Http\Controllers;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Http\Controllers\PublicController;
use Illuminate\Http\Request;

class StoriesController extends PublicController
{
    public function ajaxGetPanelInner(Request $request, BaseHttpResponse $response)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        return $response->setData(Theme::partial('components.panel-inner'));
    }
}
