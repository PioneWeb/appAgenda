<?php
namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstLetter = $this->faker->randomLetter();
        $secondLetter = $this->faker->randomLetter();

        return [
            'email' => $this->faker->email(),
            'ragione_sociale' => $this->faker->company(),
            'indirizzo' => $this->faker->streetAddress(),
            'piva' => $this->faker->regexify('[0-9]{11}') ,
            'localita' => $this->faker->city(),
            'cap' => $this->faker->postcode(),
            'provincia' => strtoupper($firstLetter.$secondLetter),
            'iban' => $this->faker->iban(),
            'telefono' => $this->faker->phoneNumber(),
            'cellulare' => $this->faker->phoneNumber(),
            'codice_destinatario' => $this->faker->regexify('[A-Z/0-9]{7}'),     /*bothify('??????##?##?###?')*/
            'pec' => $this->faker->email(),
        ];
    }
}

