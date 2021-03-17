<?php

namespace App\Http\Controllers;

use App\Repositories\TeamRepository;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    protected $teamRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
        //$this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teams.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    public function getTeams(Request $request){
       

        $search         = $request['search']['value'];
        $orderColumn    = $request['order'][0]['column'];
        $orderType      = $request['order'][0]['dir'];
        $startLimit     = $request['start'];
        $endLimit       = $request['length'];
        $draw           = $request['draw'];
        $orderBy        = (int)$orderColumn+1;

        $teamsList = $this->teamRepository->get($search, $orderBy, $orderType, $startLimit, $endLimit);

        $jsonData = array(
            'draw'              => $draw,
            'recordsTotal'      => $teamsList[1],
            'recordsFiltered'   => $teamsList[2],
            'data'              => $teamsList[0]
        );

        return response()->json($jsonData);
    }
}
