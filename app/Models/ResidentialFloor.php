<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentialFloor extends Model
{
    use HasFactory;

    protected $fillable = ['residential_id', 'floor'];
}
