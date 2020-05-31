<?php

namespace Tests\Feature;

use App\Http\Controllers\BookController;
use App\Http\Requests\BookGetRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\LibraryService;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class BookTest extends TestCase
{
    private $controller;

    public function __construct()
    {
        parent::__construct();
        $service = new LibraryService();
        $this->controller = new BookController($service);
    }

    public function setUp(): void
    {
        parent::setUp();
        self::initDB();
    }

    protected static function initDB() {
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testGetListOfBooks() {
        $request = new BookGetRequest([
            'page' => 1
        ]);

        $result = $this->controller->index($request);
        $result = $result->all();

        $this->assertTrue(count($result) == LibraryService::PER_PAGE);
        
        $this->assertTrue($result[0] instanceof BookResource);
    }

    public function testGetBook() {
        $book = Book::find(1);

        $result = $this->controller->show($book);
        
        $this->assertTrue($result instanceof BookResource);
    }

    public function testStoreBook() {
        $title = 'Custom Book Title';
        $request = new BookStoreRequest([
            'title' => $title,
            'description' => 'Custom description',
            'alias' => 'custom-description',
            'category' => 1,
            'authors' => [1,2]
        ]);

        $result = $this->controller->store($request);
        
        $this->assertTrue($result instanceof BookResource);

        $this->assertDatabaseHas('books', [
            'title' => $title
        ]);
    }

    public function testUpdateCategoryForBook() {
        $book = Book::firstWhere('category_id', 1);

        $request = new BookUpdateRequest([
            'category' => 2
        ]);

        $result = $this->controller->update($request, $book);

        $this->assertTrue($result->category->id == 2);

        $book = Book::find($book->id);
        
        $this->assertTrue($book->category_id == 2);
    }

    public function testDestroyBook() {
        $book = Book::find(1);

        $result = $this->controller->destroy($book);

        $this->assertEquals(1, $result);

        $this->assertDatabaseMissing('books', [
            'title' => $book->title
        ]);
    }
}
