<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class BookCrudTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();
    }
    
    public function testStatus201WithMessageCreatedWhenCreateABookWhenAuthenticated()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/books', $this->setData());
        $response->assertCreated();
        $response->assertJson(['message'=> "created"]);

    }

    public function testRedirectToLoginRouteIfNotAuthenticatedWith302Status()
    {
        $response = $this->post('/books', $this->setData());
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
    public function testCookiesResponseWithValidatedMessage()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/books', $this->setData());
        $response->assertCookie('validated','yes');
    }

    public function testCountOfDatabaseInBooksTableIsOne()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post('/books', $this->setData());
        $this->assertDatabaseCount('books',1);
    }

 
    public function setData($data = [])
    {
        $author = Author::factory()->create();
        $default = [
            'title' => "Gone with the wind",
            "description" => "Gone with the windGone with the windGone with the wind",
            "author_id" => $author->id,
            "ISBN" => "12b-555-6666"
        ];
        return array_merge($default, $data);
    }

}
