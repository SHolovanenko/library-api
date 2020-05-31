<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookGetRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Services\LibraryService;

class BookController extends Controller
{
    private $libraryService;

    public function __construct(LibraryService $service)
    {
        $this->libraryService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BookGetRequest $request)
    {
        $result = $this->libraryService->getBooksList($request);
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
        $result = $this->libraryService->storeBook($request);
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $result = $this->libraryService->getBook($book);
        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        $result = $this->libraryService->updateBook($request, $book);
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $result = $this->libraryService->destroyBook($book);
        return $result;
    }
}
