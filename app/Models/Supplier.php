<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;
    protected $guarded = [];

    public function spareParts()
    {
        return $this->hasMany(SparePart::class);
    }

    public function restockRequests()
    {
        return $this->hasMany(RestockRequest::class);
    }
}
