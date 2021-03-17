<?php

namespace App\Http\Controllers;

use App\Models\Companyuser;
use App\Repositories\CategoryRepository;
use App\Repositories\CompanyuserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyuserController extends Controller
{
    
    protected $companyuserRepository;
    protected $categoryRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CompanyuserRepository $companyuserRepository,
                                CategoryRepository $categoryRepository)
    {
        $this->companyuserRepository    = $companyuserRepository;
        $this->categoryRepository       = $categoryRepository;
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

        $categories = $this->categoryRepository->all();

        return view('users.list', compact(['categories']));
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
            'email'     => 'required|email|unique:App\Models\Companyuser,email',
            'age'       => 'required|integer|gt:18',
            'category'  => 'required|integer|exists:categories,id'
        ]);

        
        $companyUser = new Companyuser;
        $companyUser->name = $request->get('name');
        $companyUser->email = $request->get('email');
        $companyUser->age = $request->get('age');
        $companyUser->category()->associate($request->get('category'));
        
        if($this->companyuserRepository->save($companyUser)){
            return response()->json('Saved with success');
        
        }else{
            return response()->json('Error saving user');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->companyuserRepository->findOrFail($id);

        return response()->json(['user' => $user]);
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
            'email'     => 'required|email|unique:App\Models\Companyuser,email,'.$id.',id',
            'age'       => 'required|integer|gt:18',
            'category'  => 'required|integer|exists:categories,id'
        ]);


        $companyUser = $this->companyuserRepository->findOrFail($id);
        $companyUser->name = $request->get('name');
        $companyUser->email = $request->get('email');
        $companyUser->age = $request->get('age');
        $companyUser->category()->associate($request->get('category'));

        if($this->companyuserRepository->save($companyUser)){
            return response()->json('Saved with success');
        
        }else{
            return response()->json('Error saving user');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $userCompany = $this->companyuserRepository->findOrFail($id);
        
        if($userCompany->delete()){
            return response()->json('Deleted with success');
        }
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


    public function getUsers(Request $request){
       

        $search         = $request['search']['value'];
        $orderColumn    = $request['order'][0]['column'];
        $orderType      = $request['order'][0]['dir'];
        $startLimit     = $request['start'];
        $endLimit       = $request['length'];
        $draw           = $request['draw'];
        $orderBy        = (int)$orderColumn+1;

        $usersList = $this->companyuserRepository->getUsers($search, $orderBy, $orderType, $startLimit, $endLimit);

        $jsonData = array(
            'draw'              => $draw,
            'recordsTotal'      => $usersList[1],
            'recordsFiltered'   => $usersList[2],
            'data'              => $usersList[0]
        );

        return response()->json($jsonData);
    }
}
