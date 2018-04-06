<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookGenre extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'books_genres';
}
