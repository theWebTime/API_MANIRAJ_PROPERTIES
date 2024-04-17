<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['data'];

    public function getDataAttribute($value)
    {
        $host = request()->getSchemeAndHttpHost();
        if ($value) {
            return $host . '/images/gallery/' . $value;
        } else {
            return null;
        }
    }
}
