<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransport extends Model
{
    use HasFactory;

    protected $table = 'inventory_transports';

    protected $fillable = [
        'vehicle_id',
        'type_vehicle_id',
        'model',
        'quantity'
    ];

    static function scopeSearchByModel($query,$value){
        return $query->where('model',$value);
    }
}
