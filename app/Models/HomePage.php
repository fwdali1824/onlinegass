<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{

    protected $table = 'home_pages';
    protected $fillable = [
        'page',
        'section',
        'title',
        'heading',
        'content',
        'points',
        'images',
        'link',
        'button1',
        'buttonLink1',
        'button2',
        'buttonLink2'
    ];
}
