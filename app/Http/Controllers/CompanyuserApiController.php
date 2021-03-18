<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyuserRepository;
use Illuminate\Http\Request;

class CompanyuserApiController extends Controller
{
    protected $companyuserRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CompanyuserRepository $companyuserRepository)
    {
        $this->companyuserRepository    = $companyuserRepository;
    
        //$this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
 * Returns list of projects
 */
    public function getUsers(){
        return $this->companyuserRepository->all();
    }
}
