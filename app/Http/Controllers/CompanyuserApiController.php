<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyuserRepository;
use App\Repositories\TeamRepository;
use Illuminate\Http\Request;

class CompanyuserApiController extends Controller
{
    protected $companyuserRepository;
    protected $teamRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CompanyuserRepository $companyuserRepository,
                                TeamRepository $teamRepository)
    {
        $this->companyuserRepository    = $companyuserRepository;
        $this->teamRepository           = $teamRepository;
    
        //$this->middleware('auth');
    }


/**
 * @OA\Get(
 *      path="/api/companyusers",
 *      operationId="getUsers",
 *      tags={"Companyusers"},
 *      summary="Get list of users",
 *      description="Returns list of users",
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
    public function getUsers(){
        return $this->companyuserRepository->all();
    }



    /**
 * @OA\Get(
 *      path="/api/team/companyuser/{name}",
 *      operationId="getUserTeams",
 *      tags={"Teams"},
 *      summary="Get user teams",
 *      description="Returns teams of a specific user",
 *      @OA\Parameter(
 *          name="name",
 *          description="User name",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {

 *         }
 *     },
 * )
 */
    public function getUserTeams($name){
    
        if(!is_null($name)){

            return $this->teamRepository->getTeamsByUserName($name);

        }else{
            return response()->json('The name cannot be null');
        }
    }


}
