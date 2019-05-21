<?php

namespace App\Http\Controllers\CostAccounting;
use App\Filters\GenericFilter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CostAccounting\Traits\Currency;
use Illuminate\Http\Request;

class CostAccounting extends Controller
{

    use Currency;
    private $filter;
    private $request;

    public function __construct(GenericFilter $filter , Request $request)
    {
        $this->filter = $filter;
        $this->request = $request;
    }

    public function showCurrencies()
    {
        echo view("Dashboard.CostAccounting.Currencies");
    }
}
