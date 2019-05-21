<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 11/11/2017
 * Time: 01:20 PM
 */
namespace App\Builder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryBuilder
{
    protected $request;
    protected $builder;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->requests() as $key => $value)
        {
            if (method_exists($this , $key))
            {
                call_user_func_array([$this , $key] , array_filter([$value]));
            }
        }
        return $builder;
    }
    public function requests()
    {
        return $this->request->all();
    }
}