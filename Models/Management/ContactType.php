<?php

namespace App\Models\Management;

use App\Models\Management\Relations\ContactTypeRelations;
use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    use ContactTypeRelations;
    protected $table = 'contacttype';
    protected $primaryKey = 'id';
    public $userId = '';
    protected $fillable = ['type_name' , 'created_by' , 'modified_by'];

    public function __construct()
    {
        $this->userId = auth()->user()->id;
    }
    public function scopeLoadData($query , $filter)
    {
        return $this->Users($query , $filter);
    }
    public function Users($query , $filter)
    {
        return $filter->apply($query->with("createdByAuth" , "modifiedByAuth"));
    }
    public function generate($type_name = '')
    {
        $obj = new $this;
        $obj->type_name = $type_name;
        $obj->created_by = $this->userId;
        $obj->modified_by = $this->userId;
        $obj->save();
        return 1;
    }

    public function updateType($contact , $type)
    {
        $contact->type_name = $type;
        $contact->modified_by = $this->userId;
        $contact->save();
        return 1;
    }
}
