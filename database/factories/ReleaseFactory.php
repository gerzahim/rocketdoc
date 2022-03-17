<?php

namespace Database\Factories;

use App\Models\Release;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReleaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Release::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'document' => $this->faker->text,
            'released_at' => $this->faker->dateTime,
            'project_id' => \App\Models\Project::factory(),
        ];
    }
}
