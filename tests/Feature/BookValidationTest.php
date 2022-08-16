<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookValidationTest extends TestCase
{
    use RefreshDatabase;

    private $user ; 
    public function setUp() : void
    {
        parent::setUp();
        $this->user = User::factory()->create();

    }
    public function testTitleIsRequired()
    {
        $response = $this->actingAs($this->user)->post('/books', $this->setData(['title'=>'']));
        $response->assertSessionHasErrors(["title" => "title is required"]);
    }

    public function testDescriptionIsRequired()
    {
        $response = $this->actingAs($this->user)->post('/books', $this->setData(['description'=>'']));
        $response->assertSessionHasErrors(["description" => "description is required"]);
    }
    
    public function testDescriptionLengthMinimumIs20Characters()
    {
        $response = $this->actingAs($this->user)->post('/books', $this->setData(['description'=>'description']));
        $response->assertSessionHasErrors(["description" => "description minimum length is 20"]);
    }

    public function testAuthorIdIsValid()
    {
        $response = $this->actingAs($this->user)->post('/books', $this->setData());
        $response->assertSessionHasErrors(["author_id" => "Author must be valid"]);
    }
    public function testIsbnIsValidFormat()
    {
        $response = $this->actingAs($this->user)->post('/books', $this->setData(['ISBN'=>'rrrrrr']));
        $response->assertSessionHasErrors(["ISBN" => "ISBN must be a valid format"]);
    }

    public function testOnlyLibririanCanSeeCreateForm()
    {
        // $this->withoutExceptionHandling();
        $user = $this->user;
        $user->role = 'libririan';
        $response = $this->actingAs($this->user)->get('books/create');
        $response->assertOk();
        $response->assertViewIs('books-form');
    }

    public function testNonLibririanCannotSeeCreateForm()
    {
        $user = $this->user;
        $user->role = 'author';
        $response = $this->actingAs($this->user)->get('books/create');
        $response->assertForbidden();
    }

    public function setData($data = [])
    {
        $default = [
            'title' => "Gone with the wind",
            "description" => "description",
            "author_id" => 1,
            "ISBN" => "12b-555-6666"
        ];
        return array_merge($default, $data);
    }

}
