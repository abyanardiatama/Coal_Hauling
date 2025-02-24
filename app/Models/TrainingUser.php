<?php

namespace App\Models;

use App\Observers\TrainingUserObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([TrainingUserObserver::class])]
class TrainingUser extends Model
{
    /** @use HasFactory<\Database\Factories\TrainingUserFactory> */
    use HasFactory;
    protected $guarded = [];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
