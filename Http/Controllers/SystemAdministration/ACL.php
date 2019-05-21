<?php

namespace App\Http\Controllers\SystemAdministration;

use App\Http\Controllers\Controller as Controller;

class ACL extends Controller
{
    public function __construct()
    {
    }

    public function hasAccess()
    {
        $requestObj = new \stdClass();
        $requestObj->msg = false;
        echo json_encode($requestObj);
    }
}
