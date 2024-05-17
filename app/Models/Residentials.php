<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TypeOfProperty;

class Residentials extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'type_of_property_id', 'square_yard', 'price', 'possession', 'amenities_id', 'status_id', 'shop', 'iframe', 'location', 'brochure', 'status'];

    public function getImageAttribute($value)
    {
        $host = request()->getSchemeAndHttpHost();
        if ($value) {
            return $host . '/images/residential/' . $value;
        } else {
            return null;
        }
    }
    public function getBrochureAttribute($value)
    {
        $host = request()->getSchemeAndHttpHost();
        if ($value) {
            return $host . '/brochure/residentialBrochure/' . $value;
        } else {
            return null;
        }
    }

    protected $appends = ['top'];

    public function getTopAttribute()
    {
        $data = TypeOfProperty::whereIn('id', explode(',', $this->type_of_property_id))->pluck('id');
        return $data;
    }
}
