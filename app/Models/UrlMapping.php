<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function App\Helpers\api_prefix;

class UrlMapping extends Model
{
    protected $fillable = [
        'original_url',
        'short_code'
    ];

    public function getShortUrlAttribute(): string
    {
        return url(api_prefix().'/' . $this->short_code);
    }
}
