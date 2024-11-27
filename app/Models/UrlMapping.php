<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use function App\Helpers\api_prefix;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UrlMapping extends Model
{
    use HasFactory;
    protected $fillable = [
        'original_url',
        'short_code'
    ];
    protected $appends = ['short_url'];

    protected function shortUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => url(api_prefix() . '/' . $this->short_code),
        );
    }
}
