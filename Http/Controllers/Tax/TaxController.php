<?php

namespace App\Http\Controllers\Tax;

use App\Filters\GenericFilter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tax\Traits\SaleTaxAuthorities;

class TaxController extends Controller
{
    use SaleTaxAuthorities;
    private $request;
    private $filter;
    public function __construct(GenericFilter $filter)
    {
        $this->filter =$filter ;
        $this->request = request();
    }

    public function showSaleTaxAuthority()
    {
        echo view("Dashboard.Tax.sale-tax-authority");
    }
}
