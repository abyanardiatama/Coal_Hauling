<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\RestockRequestObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([RestockRequestObserver::class])]
class RestockRequest extends Model
{
    /** @use HasFactory<\Database\Factories\RestockRequestFactory> */
    use HasFactory;
    protected $guarded = [];

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class);
    }
}
