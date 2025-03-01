<?php

namespace Database\Factories;

use App\Models\Mapel;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Soal>
 */
class SoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mapelId = Mapel::inRandomOrder()->first()->id;
        $materiId = Materi::inRandomOrder()->first()->id;
        $userId = User::inRandomOrder()->first()->id;
        return [
            'nama_ujian' => fake()->word,
            'mapel_id' => $mapelId,
            'materi_id' => $materiId,
            'pembobotan' => "mudah",
            'pertanyaan' => fake()->text(1000),
        ];
    }
}
