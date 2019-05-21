<?php

namespace App\Models\Authentication;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Auth extends Authenticatable
{
    protected $table = 'auth';
    protected $fillable = ['email' , 'password' , 'ten_id'];
    protected $primaryKey = 'id';
    protected $hidden = ['password' , 'remember_token'];

    public function updateUser($tenid , $user)
    {
        $obj = $this->where("id" ,$user)->first();
        $obj->ten_id = $tenid;
        $obj->save();
        return 1;
    }
}
