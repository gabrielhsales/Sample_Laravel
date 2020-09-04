<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Role extends Model
{
    use AuthenticableTrait;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
