<?php

namespace App\Http\Controllers\GeneralLedger;

use App\Http\Controllers\Controller;
use App\Filters\GenericFilter;
use App\Http\Controllers\GeneralLedger\Traits\Accounts;
use App\Http\Controllers\GeneralLedger\Traits\Dimensions;
use Illuminate\Http\Request;

class GeneralLedger extends Controller
{
    use Dimensions, Accounts;
    private $request;
    private $filter;

    public function __construct(Request $request, GenericFilter $filter)
    {
        $this->filter = $filter;
        $this->request = $request;
    }

    public function showFinancialDimensionsForm()
    {
        echo view("Dashboard.GeneralLedger.Dimensions.FinancialDimension");
    }

    public function showFinancialDimensionSets()
    {
        echo view("Dashboard.GeneralLedger.Dimensions.FinancialDimensionSets");
    }

    public function showMainAccountCategories()
    {
        echo view("Dashboard.GeneralLedger.Accounts.mainaccountcategories");
    }

    public function showChartofAccounts()
    {
        echo view("Dashboard.GeneralLedger.Accounts.chartofAccounts");
    }

    public function showMainAccount()
    {
        echo view("Dashboard.GeneralLedger.Accounts.mainaccount");
    }


}
