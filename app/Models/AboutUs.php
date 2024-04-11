<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'title', 'description', 'hand_of_experience', 'million_square_feet', 'units', 'residential_property', 'commercial_property', 'plots'];

    public function getImageAttribute($value)
    {
        $host = request()->getSchemeAndHttpHost();
        if ($value) {
            return $host . '/images/aboutUs/' . $value;
        } else {
            return null;
        }
    }
}
