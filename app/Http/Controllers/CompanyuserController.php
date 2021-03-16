<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyuserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyuserController extends Controller
{
    
    protected $companyuserRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CompanyuserRepository $companyuserRepository)
    {
        $this->companyuserRepository = $companyuserRepository;
        //$this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::check()){
            return redirect()->back();
        }

        return view('users.list');
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


    public function getTeamUsers(Request $request){
       

        $search         = $request['search']['value'];
        $orderColumn    = $request['order'][0]['column'];
        $orderType      = $request['order'][0]['dir'];
        $startLimit     = $request['start'];
        $endLimit       = $request['length'];
        $draw           = $request['draw'];
        $orderBy        = (int)$orderColumn+1;

        $userTeamsList = $this->companyuserRepository->get($search, $orderBy, $orderType, $startLimit, $endLimit);

        $jsonData = array(
            'draw'              => $draw,
            'recordsTotal'      => $userTeamsList[1],
            'recordsFiltered'   => $userTeamsList[2],
            'data'              => $userTeamsList[0]
        );

        return response()->json($jsonData);
    }
}
