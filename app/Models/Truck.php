<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    /** @use HasFactory<\Database\Factories\TruckFactory> */
    use HasFactory;
    protected $guarded = [];

    public function truckReports()
    {
        return $this->hasMany(TruckReport::class);
    }

    public function shipmentPermits()
    {
        return $this->hasMany(ShipmentPermit::class);
    }

    public function sparePartUsages()
    {
        return $this->hasMany(SparePartUsage::class);
    }
}
