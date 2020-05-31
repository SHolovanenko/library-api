<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title', 'alias'
    ];

    public $timestamps = false;

    public function books() {
        return $this->hasMany(Book::class);
    }
}
