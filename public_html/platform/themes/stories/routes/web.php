<?php

// Custom routes
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Theme\Stories\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::get('ajax/get-panel-inner', 'StoriesController@ajaxGetPanelInner')
        ->name('theme.ajax-get-panel-inner');
    });
});

Theme::routes();
