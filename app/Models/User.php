<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function truckReports()
    {
        return $this->hasMany(TruckReport::class, 'driver_id');
    }

    public function shipmentPermits()
    {
        return $this->hasMany(ShipmentPermit::class, 'driver_id');
    }

    public function sparePartUsages()
    {
        return $this->hasMany(SparePartUsage::class, 'requested_by');
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'training_user');
    }


    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        //user with role admin or driver can access all panels
        if ($this->role === 'admin' || $this->role === 'driver') {
            return true;
        }
        return false;
    }
}
