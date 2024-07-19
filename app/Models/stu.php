<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stu extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    use HasFactory;
    protected $table='studentregistrations';
    protected $guard=[];
    protected $fillable=[
       'name'
       ,'email',
       'phone',
       'password',

    ];

    // public function parkingSpaces()
    // {
    //     return $this->hasMany(Parkspace::class, 'owner_id', 'id');
    // }
    // public function owner()
    // {
    //     return $this->belongsTo(Owner::class, 'owner_id', 'id');
    // }
   
}
