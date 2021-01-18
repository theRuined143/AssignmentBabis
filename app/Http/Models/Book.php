<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // things necessary for our book to be created
    protected $fillable = [
        'title', 'author', 'date_published'
    ];   
}
