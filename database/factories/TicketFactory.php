<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Faker\Core\DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Type\Integer;

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
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket' => strtoupper(bin2hex(openssl_random_pseudo_bytes(6))),
            'data' => $this->faker->date(now()),
            'ora' => $this->faker->time(),
            'customer_id' => User::factory(),
            'service_id' => $this->faker->numberBetween($min = 1, $max = 4),
            'ticket_type_id' => $this->faker->numberBetween($min = 1, $max = 3),
        ];
    }
}
