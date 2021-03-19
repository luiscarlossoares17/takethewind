<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('layouts.layout');
    }


    public function getTeamUsers(Request $request){
        
        dd("OK");

        $search         = $request['search']['value'];
        $orderColumn    = $request['order'][0]['column'];
        $orderType      = $request['order'][0]['dir'];
        $startLimit     = $request['start'];
        $endLimit       = $request['length'];
        $draw           = $request['draw'];
        $orderBy        = (int)$orderColumn+1;

        $userTeamsList = $this->userRepository->get($search, $orderBy, $orderType, $startLimit, $endLimit);

        $jsonData = array(
            'draw'              => $draw,
            'recordsTotal'      => $userTeamsList[1],
            'recordsFiltered'   => $userTeamsList[2],
            'data'              => $userTeamsList[0]
        );

        return response()->json($jsonData);
    }

}
