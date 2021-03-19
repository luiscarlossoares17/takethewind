<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Companyuser;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyuserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Companyuser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'  => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'age'   => $this->faker->numberBetween(18, 50),
            'category_id' => Category::all()->random()->id
            //'email_verified_at' => now(),
            //'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            //'remember_token' => Str::random(10),
        ];
    }
}
