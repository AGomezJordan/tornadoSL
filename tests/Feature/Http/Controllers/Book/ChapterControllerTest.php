<?php
namespace Tests\Feature;

use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ChapterControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $chapterData;
    protected $bookId;

    public function setUp(): void
    {
        parent::setUp();
        $this->bookId = Book::factory()->create([
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'published_at' => $this->faker->date,
        ])->id;
        $this->chapterData = [
            'book_id' => $this->bookId,
            'number_chapter' => $this->faker->sentence,
            'title' => $this->faker->sentence,
            'summary' => $this->faker->text,
        ];

    }

    /** @test */
    public function it_returns_all_chapters_in_one_book()
    {
        Chapter::factory()->create($this->chapterData);
        Chapter::factory()->create($this->chapterData);
        Chapter::factory()->create($this->chapterData);

        $response = $this->getJson("/api/books/$this->bookId/chapters");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'author',
                    'published_at',
                    'chapters' => [
                        '*' => [
                            'id',
                            'title',
                            'number_chapter',
                            'summary',
                        ],
                    ],         
                ],
            ])
        ->assertJsonCount(3, 'data.chapters');

    }

    /** @test */
    public function it_stores_a_new_chapter_in_one_book()
    {
        // Crete as expected chapter in a book
        $response = $this->postJson("/api/books/$this->bookId/chapters", $this->chapterData);
        $response->assertStatus(201);

        // Fail create one chapter in a book because the title is not a string
        $response = $this->postJson("/api/books/$this->bookId/chapters", [
            'number_chapter' => $this->faker->sentence,
            'title' => 1,
            'summary' => $this->faker->text,
        ]);
        $response->assertStatus(400)->assertJsonStructure(['error']);
    }

    /** @test */
    public function it_shows_a_specific_chapter_in_one_book()
    {
        $chapter = Chapter::factory()->create($this->chapterData);

        $response = $this->getJson("/api/books/$this->bookId/chapters/$chapter->id");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $chapter->id,
                ],
            ]);
        $response = $this->getJson("/api/books/$this->bookId/chapters/9999");

        $response->assertStatus(404);
    }

    /** @test */
    public function it_updates_an_existing_chapter_in_one_book()
    {
        $chapter = Chapter::factory()->create($this->chapterData);
        $updatedData = [
            'number_chapter' => 'Updated number chapter',
            'title' => 'Edited title',
            'summary' => 'Edited summary',
        ];

        $response = $this->putJson("/api/books/$this->bookId/chapters/$chapter->id", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => ['id' => $chapter->id, ...$updatedData],
            ]);
    }

    /** @test */
    public function it_deletes_an_existing_chapter_in_one_book()
    {
        $chapter = Chapter::factory()->create($this->chapterData);

        $response = $this->deleteJson("/api/books/$this->bookId/chapters/$chapter->id");
        $response->assertStatus(204);

        $response = $this->getJson("/api/books/$this->bookId/chapters/$chapter->id");
        $response->assertStatus(404);
    }
}
