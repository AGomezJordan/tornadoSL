<?php
namespace Database\Factories;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    protected $model = Chapter::class;

    public function definition()
    {
        return [
            'number_chapter' => $this->faker->sentence,
            'title' => $this->faker->sentence,
            'summary' => $this->faker->text,
        ];
    }
}