<?php
namespace App\Filters;
// This ClASS will contains all the filters as a functions
use App\Builder\QueryBuilder;
use Illuminate\Http\Request;

class GenericFilter extends QueryBuilder
{
    public function take($count = 0)
    {
        return $this->builder->take($count);
    }
    public function latest($order = 'asc')
    {
        return $this->builder->orderBy('id' , $order);
    }
    public function skip($count = 0)
    {
        return $this->builder->skip($count);
    }
    public function filter($data = array())
    {
        if(array_key_exists("filters" , $data))
        {
            return $this->builder->where($data['filters'][0]['field'],'like','%'.$data['filters'][0]['value'].'%');
        }
        return;
    }
}