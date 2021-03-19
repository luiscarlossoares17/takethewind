<?php

namespace Database\Factories;

use App\Models\Companyuser;
use App\Models\Team;
use App\Models\Teamusers;
use App\Models\Userlevel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamusersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teamusers::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'team_id' => Team::factory(),
            'companyuser_id' => Companyuser::factory(),
            'userlevel_id' => Userlevel::all()->random()->id
        ];
    }
}
