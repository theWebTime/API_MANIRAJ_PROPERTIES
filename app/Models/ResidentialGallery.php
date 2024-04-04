<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentialGallery extends Model
{
    use HasFactory;

    protected $fillable = ['residential_id', 'is_pic', 'data'];

    public function getDataAttribute($value)
    {
        $host = request()->getSchemeAndHttpHost();
        if ($value) {
            return $host . '/images/residentialGallery/' . $value;
        } else {
            return null;
        }
    }
}
