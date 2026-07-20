<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'site_tagline',

        'logo',
        'footer_logo',
        'favicon',

        'meta_title',
        'meta_description',
        'meta_keywords',

        'contact_email',
        'support_email',
        'phone',
        'address',

        'facebook_url',
        'instagram_url',
        'twitter_url',
        'linkedin_url',
        'youtube_url',

        'currency_code',
        'currency_symbol',

        'maintenance_mode',
        'maintenance_message',

        'footer_about',
        'copyright_text',
    ];

    protected function casts(): array
    {
        return [
            'maintenance_mode' => 'boolean',
        ];
    }
}