<?php
/**
 * Created by PhpStorm.
 * User: Sunna
 * Date: 07/01/2018
 * Time: 01:49 PM
 */

namespace App\Http\Controllers\MasterPlanning\Traits;

use Facades\App\Models\MasterPlanning\Segment;

trait SegmentTrait
{
    public function GetSegments()
    {
        if ($this->request->has('take')) {
            $take = $this->request->get('take') > 0 ? $this->request->get('take') : 0;
            $skip = $this->request->has('skip') ? $this->request->get('skip') : 0;
            $model = Segment::class;
            $data = $model::LoadData($this->filter);
            echo shapeWithKendo($skip, $take, $data->count(), $data->get());
        } else {
            echo Segment::all();
        }
    }


    public function saveSegments()
    {
        $requestObj = new \stdClass();
        if(Segment::isExists($this->request) > 0)
        {
            $requestObj->status = 'error';
            $requestObj->msg = 'Segment Already Exists';
        }
        else{
            Segment::saveSegment($this->request);
            $requestObj->status = 'success';
            $requestObj->msg = 'Segment Saved Successfully';
        }
        echo json_encode($requestObj);
    }
}