<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentialAmenities extends Model
{
    use HasFactory;

    protected $fillable = ['residentials_id', 'amenities_id'];
}
