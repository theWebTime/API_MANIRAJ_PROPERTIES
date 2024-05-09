<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentialInquiry extends Model
{
    use HasFactory;

    protected $fillable = ['client_name', 'client_number', 'residential_id'];
}
