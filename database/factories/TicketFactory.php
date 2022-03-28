<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $issueNumber = $this->faker->numberBetween(1000, 9000);
        return [
            'key'     => 'TSV4-'.$issueNumber,
            'summary' => $this->faker->sentence,
            'url'     => 'https://paperstreet.atlassian.net/browse/TSV4-'.$issueNumber,
        ];
    }
}
