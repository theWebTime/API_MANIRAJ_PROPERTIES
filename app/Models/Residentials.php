<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residentials extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'type_of_property_id', 'square_yard', 'amenities_id', 'status_id', 'shop', 'iframe', 'location', 'brochure', 'status'];

    public function getImageAttribute($value)
    {
        $host = request()->getSchemeAndHttpHost();
        if ($value) {
            return $host . '/images/residential/' . $value;
        } else {
            return null;
        }
    }
}
