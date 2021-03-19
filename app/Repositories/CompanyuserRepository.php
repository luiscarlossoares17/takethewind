<?php

namespace App\Repositories;

use App\Models\Companyuser;
use Illuminate\Support\Facades\DB;


class CompanyuserRepository extends BaseRepository
{
    protected $queryFilter;

    public function __construct(Companyuser $_model)
    {
        $this->model = $_model;
        $this->query = $this->model->newQuery();
    }

    #region Basic
    public function get($search = null, $orderBy = null, $orderType = null, $startLimit = null, $endLimit = null)
    {

        $objects = DB::table('companyusers as CU')
                ->leftJoin('teamusers as TU', 'TU.companyuser_id', '=', 'CU.id')
                ->leftJoin('teams as T', 'T.id', '=', 'TU.team_id')
                ->select(
                    'CU.name as user',
                    'CU.email',
                    'T.name as team'
                );

        $totalObjects = $objects->get()->count();

        //dd($totalObjects);

        if (!empty($search)) {

            $objects->where(function ($query) {
                $query->where('CU.name', 'LIKE', '?')
                    ->orWhere('CU.email', 'LIKE', '?')
                    ->orWhere('T.name', 'LIKE', '?');
            });

            $searchList = ['%' . $search . '%', '%' . $search . '%', '%' . $search . '%'];

            // Order by must be after our filters
            $objects->orderByRaw($orderBy . ' ' . $orderType);

            $countObjects = DB::raw($objects->toSql());

            // COUNT ALL SEARCHED RECORDS
            $totalSearchedList = DB::select($countObjects, $searchList);

            $totalRecordsFiltered = count($totalSearchedList);

            // GET ONLY RECORDS OF 1 PAGE WITH START NUMBER AND LENGTH
            if ($endLimit != -1) {
                $objects = $objects
                    ->skip($startLimit)
                    ->take($endLimit);
            }
            $objects = DB::raw($objects->toSql());

            // GET SELECTED RECORDS
            $objectsList = DB::select($objects, $searchList);
        } else {

            $totalRecordsFiltered = $totalObjects;
            // GET ONLY RECORDS OF 1 PAGE WITH START NUMBER AND LENGTH
            if ((int)$endLimit != -1) {
                $objectsList = $objects
                    ->skip($startLimit)
                    ->take($endLimit);
            }
            $objectsList = $objects->get();
        }

        $data = [$objectsList, $totalObjects, $totalRecordsFiltered];

        return $data;
    }


    public function search($search, $criteria){
        //TODO: Implements search method
    }


    public function getUsers($search = null, $orderBy = null, $orderType = null, $startLimit = null, $endLimit = null){
        $objects = DB::table('companyusers as CU')
                ->leftJoin('categories as C', 'C.id', '=', 'CU.category_id')
                ->select(
                    'CU.id',
                    'CU.name as user',
                    'CU.email',
                    'CU.age',
                    'C.name as category'
                );

        $totalObjects = $objects->get()->count();

        //dd($totalObjects);

        if (!empty($search)) {

            $objects->where(function ($query) {
                $query->where('CU.name', 'LIKE', '?')
                    ->orWhere('CU.email', 'LIKE', '?')
                    ->orWhere('CU.age', 'LIKE', '?')
                    ->orWhere('C.name', 'LIKE', '?');
            });

            $searchList = ['%' . $search . '%', '%' . $search . '%', '%' . $search . '%', '%' . $search . '%'];

            // Order by must be after our filters
            $objects->orderByRaw($orderBy . ' ' . $orderType);

            $countObjects = DB::raw($objects->toSql());

            // COUNT ALL SEARCHED RECORDS
            $totalSearchedList = DB::select($countObjects, $searchList);

            $totalRecordsFiltered = count($totalSearchedList);

            // GET ONLY RECORDS OF 1 PAGE WITH START NUMBER AND LENGTH
            if ($endLimit != -1) {
                $objects = $objects
                    ->skip($startLimit)
                    ->take($endLimit);
            }
            $objects = DB::raw($objects->toSql());

            // GET SELECTED RECORDS
            $objectsList = DB::select($objects, $searchList);
        } else {

            $totalRecordsFiltered = $totalObjects;
            // GET ONLY RECORDS OF 1 PAGE WITH START NUMBER AND LENGTH
            if ((int)$endLimit != -1) {
                $objectsList = $objects
                    ->skip($startLimit)
                    ->take($endLimit);
            }
            $objectsList = $objects->get();
        }

        $data = [$objectsList, $totalObjects, $totalRecordsFiltered];

        return $data;
    }


    public function usersToSelect($search = null, $orderBy = null, $orderType = null, $startLimit = null, $endLimit = null){
        $objects = DB::table('companyusers as U')
                ->leftJoin('categories as C', 'C.id', '=', 'U.category_id')
                ->select(
                    'U.id',
                    'U.name',
                    'U.age',
                    'U.email',
                    'C.name as category',
                    
                );

        $totalObjects = $objects->get()->count();

        //dd($totalObjects);

        if (!empty($search)) {

            $objects->where(function ($query) {
                $query->where('U.name', 'LIKE', '?')
                    ->orWhere('U.email', 'LIKE', '?')
                    ->orWhere('U.age', 'LIKE', '?')
                    ->orWhere('C.name', 'LIKE', '?');
            });

            $searchList = ['%' . $search . '%', '%' . $search . '%', '%' . $search . '%', '%' . $search . '%'];

            // Order by must be after our filters
            $objects->orderByRaw($orderBy . ' ' . $orderType);

            $countObjects = DB::raw($objects->toSql());

            // COUNT ALL SEARCHED RECORDS
            $totalSearchedList = DB::select($countObjects, $searchList);

            $totalRecordsFiltered = count($totalSearchedList);

            // GET ONLY RECORDS OF 1 PAGE WITH START NUMBER AND LENGTH
            if ($endLimit != -1) {
                $objects = $objects
                    ->skip($startLimit)
                    ->take($endLimit);
            }
            $objects = DB::raw($objects->toSql());

            // GET SELECTED RECORDS
            $objectsList = DB::select($objects, $searchList);
        } else {

            $totalRecordsFiltered = $totalObjects;
            // GET ONLY RECORDS OF 1 PAGE WITH START NUMBER AND LENGTH
            if ((int)$endLimit != -1) {
                $objectsList = $objects
                    ->skip($startLimit)
                    ->take($endLimit);
            }
            $objectsList = $objects->get();
        }

        $data = [$objectsList, $totalObjects, $totalRecordsFiltered];

        return $data;
    }



    public function getTeamUsers($teamId){

        $userTeam = DB::table('teamusers as TU')
                        ->where('TU.team_id', '=', '?')
                        ->whereNull('TU.deleted_at')
                        ->select('TU.companyuser_id');


        $teamUserQuery = DB::table('companyusers as CU')
                            ->leftJoin('teamusers as TU', function($join){
                                $join->on('CU.id', '=', 'TU.companyuser_id')
                                    ->where('TU.team_id', '=', '?');
                            })
                            ->whereNull('TU.deleted_at')
                            ->select('CU.id',
                                     'CU.name',
                                     'CU.age',
                                     'CU.email',
                                     'CU.name as category',
                                     'TU.userlevel_id',
                                     DB::raw("IF(CU.id IN (". DB::raw($userTeam->toSql()) ."), 'TRUE', 'FALSE') as checkbox"));


        $teamUserQuery = DB::raw($teamUserQuery->toSql());

        $companyUsersList = DB::select($teamUserQuery, [$teamId, $teamId]);

        return $companyUsersList;

    }


    
    #endregion
}