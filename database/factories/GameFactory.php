<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = ['andy','max','pietro','sophie','alex','david'];
        $colors = ['red','blue'];
        $WO = $this->faker->randomElement($names);
        $WD = $this->faker->randomElement(array_diff($names, [$WO]));
        $LO = $this->faker->randomElement(array_diff($names, [$WO, $WD]));
        $LD = $this->faker->randomElement(array_diff($names, [$WO, $WD, $LO]));
        return [
            'WO' => $WO,
            'WD' => $WD,
            'LO' => $LO,
            'LD' => $LD,
            'color' => $this->faker->randomElement($colors),
            'score' => $this->faker->numberBetween(0,9)
        ];
    }
}
