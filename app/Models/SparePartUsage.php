<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\SparePartUsageObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([SparePartUsageObserver::class])]
class SparePartUsage extends Model
{
    /** @use HasFactory<\Database\Factories\SparePartUsageFactory> */
    use HasFactory;
    protected $guarded = [];

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class);
    }

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
}
