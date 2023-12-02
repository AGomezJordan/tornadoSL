<?php
namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $bookData;

    public function setUp(): void
    {
        parent::setUp();
        $this->bookData = [
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'published_at' => $this->faker->date,
        ];
    }

    /** @test */
    public function it_returns_all_books()
    {
        Book::factory()->create($this->bookData);
        Book::factory()->create($this->bookData);
        Book::factory()->create($this->bookData);


        $response = $this->getJson('/api/books');
        $response->assertStatus(200)
            ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'author',
                    'published_at',
                ],
            ],
        ])
        ->assertJsonCount(3, 'data');

    }

    /** @test */
    public function it_stores_a_new_book()
    {
        // Crete as expected one book
        $response = $this->postJson('/api/books', $this->bookData);
        $response->assertStatus(201);

        // Fail create one book because the published_at is not a date
        $response = $this->postJson('/api/books', [
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'published_at' => $this->faker->name,
        ]);
        $response->assertStatus(400)->assertJsonStructure(['error']);
    }

    /** @test */
    public function it_shows_a_specific_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/$book->id");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $book->id,
                ],
            ]);
        $response = $this->getJson('/api/books/99999');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_updates_an_existing_book()
    {
        $book = Book::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
            'author' => 'Jane Doe',
            'published_at' => '2023/02/01',
        ];

        $response = $this->putJson("/api/books/$book->id", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => ['id' => $book->id, ...$updatedData],
            ]);
    }

    /** @test */
    public function it_deletes_an_existing_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/$book->id");
        $response->assertStatus(204);

        $response = $this->getJson("/api/books/$book->id");
        $response->assertStatus(404);
    }
}
