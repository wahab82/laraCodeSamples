<?php

namespace App\Http\Controllers\AccountsPayable;

use App\Filters\GenericFilter;
use App\Http\Controllers\AccountsPayable\Traits\VendorGroup;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class AccountsPayable extends Controller
{
    use VendorGroup;

    public $request;
    public $filter;

    public function __construct(Request $request , GenericFilter $filter)
    {
        $this->request = $request;
        $this->filter = $filter;
    }
    public function showVendorGroup()
    {
        echo view("Dashboard.AccountsPayable.VendorGroup.vendor-group");
    }


}
