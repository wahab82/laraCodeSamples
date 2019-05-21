<?php

namespace App\Http\Controllers;

use App\Models\Authentication\Auth;
use App\Models\Management\Company;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getEntities()
    {
        return (new Company())->getEntities();
    }

    public function updateEntity(Request $request)
    {
        $requestObj = [];
        if ($request->get("ten") > 0)
        {
            if(\auth()->user())
            {
                $requestObj['data'] = (new Auth())->updateUser($request->get("ten") , \auth()->user()->id);
            }
        }
        echo json_encode($requestObj);
    }
}
