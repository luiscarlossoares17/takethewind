<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyuserRepository;
use App\Repositories\TeamRepository;
use App\Repositories\UserlevelRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Teamusers;

class TeamController extends Controller
{

    protected $teamRepository;
    protected $companyuserRepository;
    protected $userlevelRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TeamRepository $teamRepository,
                                UserlevelRepository $userlevelRepository,
                                CompanyuserRepository $companyuserRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->userlevelRepository  = $userlevelRepository;
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
        return view('teams.list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|string',
            'users.*'   => 'required|integer|exists:companyusers,id',
            'userlevels.*'   => 'required|integer|exists:userlevels,id'
        ]);


        $team = new Team;
        $team->name = $request->get('name');
        $this->teamRepository->save($team);

        $users = $request->get('users');
        $usersLevels = $request->get('userlevels');

        for($i = 0; $i < count($users); $i++){
            $teamUser = new Teamusers;
            $teamUser->user()->associate($users[$i]);
            $teamUser->userlevel()->associate($usersLevels[$i]);
            $teamUser->team()->associate($team->id);
            $teamUser->save();
        }

        return response()->json('Saved with success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = $this->teamRepository->findOrFail($id);

        return response()->json($team);
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
        $this->validate($request, [
            'name'      => 'required|string',
            'users.*'   => 'integer|exists:companyusers,id',
            'userlevels.*' => 'required|integer|exists:userlevels,id'
        ]);

        $team = $this->teamRepository->findOrFail($id);
        $team->name = $request->get('name');
        $this->teamRepository->save($team);

        $users = $request->get('users');
        $usersLevels = $request->get('userlevels');

        if($users == null){
            $this->teamRepository->deleteTeamMembers($team->id);
        }else{
            //Delete users
            //$this->teamRepository->deleteTeamUsers($team->id, $users);

            for($i = 0; $i < count($users); $i++){

                $this->teamRepository->deleteTeamUsers($team->id, $users[$i], $usersLevels[$i], $users);
                
                $teamUser = new Teamusers;
                $teamUser->user()->associate($users[$i]);
                $teamUser->userlevel()->associate($usersLevels[$i]);
                $teamUser->team()->associate($team->id);
                $teamUser->save();
            }
        }

        

        return response()->json('Saved with success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = $this->teamRepository->findOrFail($id);
        $team->delete();
        $this->teamRepository->deleteTeamMembers($team->id);

        return response()->json('Deleted with success');
        
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



    public function getUsers(Request $request){


        $search         = $request['search']['value'];
        $orderColumn    = $request['order'][0]['column'];
        $orderType      = $request['order'][0]['dir'];
        $startLimit     = $request['start'];
        $endLimit       = $request['length'];
        $draw           = $request['draw'];
        $orderBy        = (int)$orderColumn+1;

        $usersRequest = $request->get('team');

        if($usersRequest == 'all'){
            $teamsList = $this->companyuserRepository->usersToSelect($search, $orderBy, $orderType, $startLimit, $endLimit);


            $userLevels = $this->userlevelRepository->all();


            $selectElement = '<select name="userLevel[]" class="form-control">
                                <option></option>';
            foreach($userLevels as $userLevel){
                $selectElement .= '<option value="'.$userLevel->id.'">'.$userLevel->name.'</option>';
            }

            $selectElement .= '</select>';

            $jsonData = array(
                'draw'              => $draw,
                'recordsTotal'      => $teamsList[1],
                'recordsFiltered'   => $teamsList[2],
                'data'              => $teamsList[0],
                'select'            => $selectElement
            );

            return response()->json($jsonData);
        
        }else{

            $data = array();

            $userLevels = $this->userlevelRepository->all();


            $companyUsersList = $this->companyuserRepository->getTeamUsers($usersRequest);

            $totalRecords = count($companyUsersList);

            foreach($companyUsersList as $companyUser){

                $teamMember = false;
                $row        = array();

                if($companyUser->checkbox == 'TRUE'){
                    $teamMember = true;
                }

                $selectElement = '<select name="userLevel[]" class="form-control">
                                <option></option>';
                foreach($userLevels as $userLevel){
                    $selected = '';
                    if($userLevel->id == $companyUser->userlevel_id){
                        $selected = 'selected';
                    }
                    $selectElement .= '<option '.$selected.' value="'.$userLevel->id.'">'.$userLevel->name.'</option>';
                }
                $selectElement .= '</select>';

                array_push($row, $companyUser->id, $companyUser->name, $companyUser->age,
                $companyUser->email, $companyUser->category, $selectElement, $teamMember);

                $data[] = $row;
                
            }

            $jsonData = array(
                'draw'              => $draw,
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $totalRecords,
                'data'              => $data,
            );

            return response()->json($jsonData);

        }

    }
}
