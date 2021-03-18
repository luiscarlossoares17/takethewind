<?php

namespace App\Repositories;

use App\Models\Team;
use App\Models\Teamusers;
use Illuminate\Support\Facades\DB;


class TeamRepository extends BaseRepository
{
    protected $queryFilter;

    public function __construct(Team $_model)
    {
        $this->model = $_model;
        $this->query = $this->model->newQuery();
    }

    #region Basic
    public function get($search = null, $orderBy = null, $orderType = null, $startLimit = null, $endLimit = null)
    {

        $objects = DB::table('teams as T')
                ->select('T.*');

        $totalObjects = $objects->get()->count();

        //dd($totalObjects);

        if (!empty($search)) {

            $objects->where(function ($query) {
                $query->where('T.name', 'LIKE', '?');
            });

            $searchList = ['%' . $search . '%'];

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


    public function deleteTeamUsers($teamId, $userId, $userLevel, $usersIdsList){
        return DB::table('teamusers')->where(function($query) use($teamId, $userId, $userLevel){
                        $query->where('team_id', '=', $teamId)
                        ->where('companyuser_id', '=', $userId)
                        ->where('userlevel_id', '!=', $userLevel);
                    })
                    ->orWhereNotIn('companyuser_id', $usersIdsList)
                    ->update([
                        'deleted_at' => now()
                    ]);
    }

    public function deleteTeamMembers($teamId){
        return DB::table('teamusers')->where('team_id', '=', $teamId)
                    ->update([
                        'deleted_at' => now()
                    ]);
    }
    
    #endregion
}