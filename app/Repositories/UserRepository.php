<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;


class UserRepository extends BaseRepository
{
    protected $queryFilter;

    public function __construct(User $_model)
    {
        $this->model = $_model;
        $this->query = $this->model->newQuery();
    }

    #region Basic
    public function get($search = null, $orderBy = null, $orderType = null, $startLimit = null, $endLimit = null)
    {

        $objects = DB::table('users as U')
                ->leftJoin('teamusers as TU', 'TU.user_id', '=', 'U.id')
                ->leftJoin('teams as T', 'T.id', '=', 'TU.team_id')
                ->select(
                    'U.name as user',
                    'U.email',
                    'T.name as team'
                );

        $totalObjects = $objects->get()->count();

        //dd($totalObjects);

        if (!empty($search)) {

            $objects->where(function ($query) {
                $query->where('U.name', 'LIKE', '?')
                    ->orWhere('U.email', 'LIKE', '?')
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
    
    #endregion
}