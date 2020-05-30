<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public $timestamps = false;

    public function books() {
        return $this->belongsToMany(Book::class);
    }
}
