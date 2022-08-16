<?php

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BookApiTest extends TestCase 
{
    use RefreshDatabase;

    public function testGetJsonFromBookRequest()
    {
        $book = Book::factory()->create();
        $response = $this->get('api/books');
        $response->assertJson([
            'books' => [
                [
                    "book_id" => $book->id,
                    "title" => $book->title,
                    "description" => $book->description,
                    "author_name" => $book->author->name,
                    "ISBN" => $book->ISBN
                ]
            ]
        ]);
    }

}
?>