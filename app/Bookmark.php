<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = ['name', 'url', 'user_id', 'summary', 'image'];
}
