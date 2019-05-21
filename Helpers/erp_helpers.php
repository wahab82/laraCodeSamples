<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 02/11/2017
 * Time: 10:59 PM
 */

if ( ! function_exists("load_routes"))
{
    function load_routes()
    {
        \Illuminate\Support\Facades\Auth::routes();
        \Illuminate\Support\Facades\Auth::defaultDashboard();
        \Illuminate\Support\Facades\Auth::SPA();
        \Illuminate\Support\Facades\Auth::dataRequest();
    }

}
if ( ! function_exists("shapeWithKendo"))
{
    function shapeWithKendo($to , $from , $count , $data)
    {
        return '{"pageSize":'.$to.',"page":'.$from.',"total":'.$count.',"data":'.$data.'}';
    }
}

if( ! function_exists("ten"))
{
    function ten()
    {
        return auth()->user()->ten_id;
    }
}
if( ! function_exists("Validate"))
{
    function Validate( $request , $arr)
    {
        return Illuminate\Support\Facades\Validator::make($request , $arr);
    }
}
