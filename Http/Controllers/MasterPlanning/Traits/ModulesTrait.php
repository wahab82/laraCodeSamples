<?php
/**
 * Created by PhpStorm.
 * User: Sunna
 * Date: 13/01/2018
 * Time: 11:55 PM
 */

namespace App\Http\Controllers\MasterPlanning\Traits;

use App\Models\GeneralLedger\Chartofaccount;
use Facades\App\Models\MasterPlanning\Modules;

trait ModulesTrait
{
    public function saveModules()
    {
        Modules::saveModules(Chartofaccount::class , 'Chartofaccount');
    }

    public function getAllModules()
    {
        echo Modules::all();
    }
}