<?php

namespace App\Services;

use App\Http\Requests\BookGetRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Str;

class LibraryService extends BaseService
{
    const PER_PAGE = 20;

    public function getBooksList(BookGetRequest $request) {
        $query = Book::with(['authors', 'category']);

        if ($request->has('sort')) {
            $sortString = $request->input('sort');
            $sorts = explode(',', $sortString);

            foreach ($sorts as $sort) {
                $sort = trim($sort);
                $order = Str::startsWith($sort, '-') ? 'desc' : 'asc';
                $sort = str_replace('-', '', $sort);
                $query->orderBy($sort, $order);
            }
        }

        if ($request->has('title')) {
            $query->where('books.title', 'like', '%'.$request->input('title').'%');
        }

        if ($request->has('author')) {
            $query->whereHas('authors', function($q) use ($request) {
                $q->where('authors.name', 'like', '%'.$request->input('author').'%');
            });
        }

        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('categories.title', 'like', '%'.$request->input('category').'%');
            });
        }

        $books = $query->paginate(self::PER_PAGE);
        
        return BookResource::collection($books);
    }

    public function getBook($book) {
        return new BookResource($book);
    }

    public function storeBook(BookStoreRequest $request) {
        $authorIds = $request->input('authors');
        $categoryId = $request->input('category');
        
        $book = new Book();
        $book->title = $request->input('title');
        $book->alias = $request->input('alias');
        $book->description = $request->input('description');
        $book->category()->associate($categoryId);
        $book->save();

        $book->authors()->attach($authorIds);
        
        return new BookResource($book);
    }

    public function updateBook(BookUpdateRequest $request, $book) {
        $categoryId = $request->input('category');
        $book->category()->associate($categoryId);
        $book->push();
        
        return new BookResource($book);
    }

    public function destroyBook($book) {
        $book->authors()->detach();
        return $book->delete();
    }
}
