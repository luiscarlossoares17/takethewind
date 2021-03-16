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
    
    #endregion
}