<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlShort extends Model
{
    use HasFactory;

    protected $table = 'url_short';

    protected $fillable = [
        'original', 'short', 'code', 'clicks'
    ];
}
