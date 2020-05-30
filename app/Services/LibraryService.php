<?php

namespace App\Services;

use App\Models\Book;

class LibraryService extends BaseService
{
    public function getBooksList($params) {
        return Book::all();
    }
}
