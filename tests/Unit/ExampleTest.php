<?php

namespace Tests\Unit;

use App\Models\Companyuser;
use App\Models\Team;
use App\Models\Teamusers;
use Faker\Factory;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        $companyuserRepository = resolve('App\Repositories\CompanyuserRepository');

        $categoryID = 1; //Category ID 1 represents a software developer

        $companyUser = new Companyuser;
        $companyUser->name = 'Takethewind User';
        $companyUser->email = 'takethewind@takethewind.pt';
        $companyUser->age   = 29;
        $companyUser->category()->associate($categoryID);

        $companyuserRepository->save($companyUser);


        $this->assertDatabaseHas('companyusers', [
            'email' => $companyUser->email
        ]);

    }




    public function testcreateRandomTeamsTest()
    {

        $teamRepository = resolve('App\Repositories\TeamRepository');

        $team = Team::factory()->make();
        $teamRepository->save($team);

        $this->assertDatabaseHas('teams', [
            'name' => $team->name
        ]);
        
    }


    public function testcreateRandomCompanyuserTest()
    {

        $companyuserRepository = resolve('App\Repositories\CompanyuserRepository');

        $user = Companyuser::factory()->make();
        $companyuserRepository->save($user);

        $this->assertDatabaseHas('companyusers', [
            'name' => $user->name
        ]);
        
    }


    public function testcreateRandomTeamUserTest()
    {

        $teamUser = Teamusers::factory()->make();
        $teamUser->save();

        $this->assertDatabaseHas('teamusers', [
            'team_id' => $teamUser->team_id,
            'companyuser_id' => $teamUser->companyuser_id,
            'userlevel_id'  => $teamUser->userlevel_id
        ]);
        
    }

}
