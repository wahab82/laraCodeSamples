<?php

namespace App\Models\MasterPlanning;

use Illuminate\Database\Eloquent\Model;

class MaskSegment extends Model
{
    protected $table = 'masksegment';
    protected $primaryKey = 'id';
    protected $fillable = ['mask_id' , 'segment_id' , 'ten_id','value','length'];

    public function saveMaskSegment($request)
    {
        $obj = new $this;
        $obj->mask_id = $request->get("mask");
        $obj->segment_id = $request->get("segment");
        $obj->ten_id = ten();
        $obj->value = $request->get("value");
        $obj->length = $request->get("length");
        return $obj->save();
    }

    public function scopeGetSegment($query , $maskId)
    {
        return $query->with("segment")->where("mask_id" , $maskId);
    }
    public function segment()
    {
        return $this->belongsTo(Segment::class , 'segment_id','id');
    }
}
