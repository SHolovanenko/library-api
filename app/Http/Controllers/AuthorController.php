<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorStoreRequest;
use App\Models\Author;
use App\Services\LibraryService;
use Illuminate\Http\Request;

class AuthorController extends Controller
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
    public function index()
    {
        $result = $this->libraryService->getAuthors();
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorStoreRequest $request)
    {
        $result = $this->libraryService->storeAuthor($request);
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        $result = $this->libraryService->getAuthor($author);
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $result = $this->libraryService->destroyAuthor($author);
        return $result;
    }
}
