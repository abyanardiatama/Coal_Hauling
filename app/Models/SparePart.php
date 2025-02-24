<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    /** @use HasFactory<\Database\Factories\SparePartFactory> */
    use HasFactory;
    protected $guarded = [];

    public function sparePartUsages()
    {
        return $this->hasMany(SparePartUsage::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function restockRequests()
    {
        return $this->hasMany(RestockRequest::class);
    }
}
