<?php
/**
 * Created by PhpStorm.
 * User: freelancer
 * Date: 2019/6/29
 * Time: 18:24
 */

use Illuminate\Support\Facades\Route;

/**
 * 根据 route 将 container 定义制定的 class 类
 *
 *  <div id="app" class="{{ route_class() }}-page">
 */
function route_class()
{
    $currentRouteName = Route::currentRouteName();
    return str_replace('.', '-', $currentRouteName);
}

function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}
