<?php

namespace App\Http\Controllers;

use App\Repositories\TeamRepository;
use Illuminate\Http\Request;

class TeamApiController extends Controller
{
    protected $teamRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TeamRepository $teamRepository)
    {
    
        $this->teamRepository           = $teamRepository;
    
        //$this->middleware('auth');
    }

        /**
 * @OA\Get(
 *      path="/api/teams",
 *      operationId="getTeams",
 *      tags={"Teams"},
 *      summary="Get list of teams",
 *      description="Returns list of teams",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           
 *       }
 *     )
 *
 * Returns list of users
 */
public function getTeams(){
    return $this->teamRepository->all();
}
}

