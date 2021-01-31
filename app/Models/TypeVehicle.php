<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeVehicle extends Model
{
    use HasFactory;

    protected $table = 'type_vehicles';

    public function scopeSearchByDescription($query,$value){
        return $query->where('description',$value);
    }
}
