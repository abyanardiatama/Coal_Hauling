<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentPermit extends Model
{
    /** @use HasFactory<\Database\Factories\ShipmentPermitFactory> */
    use HasFactory;
    protected $guarded = [];
    // protected $casts = [
    //     'file_path' => 'array', // Agar Laravel otomatis mengubah JSON ke array
    // ];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class);
    }
}
