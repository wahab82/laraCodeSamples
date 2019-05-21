<?php
namespace App\Models\Management\Relations;

use App\Models\Authentication\Auth;

trait ContactTypeRelations
{
    public function createdByAuth()
    {
        return $this->belongsTo(Auth::class , 'created_by' , 'id');
    }
    public function modifiedByAuth()
    {
        return $this->belongsTo(Auth::class , 'modified_by' , 'id');
    }

    public function auth()
    {
        return [$this->createdByAuth() , $this->modifiedByAuth()];
    }
}