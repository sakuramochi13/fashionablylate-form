<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $len = $this->faker->randomElement([10, 11]);
        $tel = '0' . $this->faker->numerify(str_repeat('#', $len - 1));

        return [
            'category_id' => fn () => Category::inRandomOrder()->value('id'),

            'first_name'  => $this->faker->firstName(),
            'last_name'   => $this->faker->lastName(),
            'gender'      => $this->faker->randomElement([1, 2, 3]),
            'email'       => $this->faker->unique()->safeEmail(),
            'tel'         => $tel,
            'address'     => $this->faker->address(),
            'building'    => $this->faker->optional()->secondaryAddress(),
            'detail'      => $this->faker->text(100), 
        ];
    }
}
