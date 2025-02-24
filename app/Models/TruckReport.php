<?php

namespace App\Models;

use App\Observers\TruckReportObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([TruckReportObserver::class])]
class TruckReport extends Model
{
    /** @use HasFactory<\Database\Factories\TruckReportFactory> */
    use HasFactory;
    protected $guarded = [];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
