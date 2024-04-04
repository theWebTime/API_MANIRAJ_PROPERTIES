<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = ['logo', 'email1', 'email2', 'phone_number1', 'phone_number2', 'address', 'iframe', 'video_link', 'facebook_link', 'instagram_link', 'youtube_link', 'whatsapp_number'];

    public function getLogoAttribute($value)
    {
        $host = request()->getSchemeAndHttpHost();
        if ($value) {
            return $host . '/images/siteSetting/' . $value;
        } else {
            return null;
        }
    }
}
