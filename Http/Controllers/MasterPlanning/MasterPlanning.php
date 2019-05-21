<?php

namespace App\Http\Controllers\MasterPlanning;

use App\Filters\GenericFilter;
use App\Http\Controllers\MasterPlanning\Traits\COAPlanning;
use App\Http\Controllers\MasterPlanning\Traits\MaskTrait;
use App\Http\Controllers\MasterPlanning\Traits\ModulesTrait;
use App\Http\Controllers\MasterPlanning\Traits\SegmentTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class MasterPlanning extends Controller
{
    use MaskTrait,SegmentTrait,COAPlanning,ModulesTrait;
    private $request;
    private $filter;
    public function __construct(Request $request , GenericFilter $filter)
    {
        $this->filter = $filter;
        $this->request =  $request;
    }
    public function showMasking()
    {
        return view("Dashboard.MasterPlanning.masking");
    }
    public function showSegments()
    {
        return view("Dashboard.MasterPlanning.segments");
    }

    public function showCOAPlanning()
    {
        return view("Dashboard.MasterPlanning.COAPlanning");
    }

    public function showModuleMaskMap()
    {
        return view("Dashboard.MasterPlanning.moduleMaskMap");
    }

}
