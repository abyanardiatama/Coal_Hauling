<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    /** @use HasFactory<\Database\Factories\TrainingFactory> */
    use HasFactory;
    protected $guarded = []; 

    public function trainingUsers()
    {
        return $this->hasMany(TrainingUser::class);
    }

}
