<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\DB;


class CategoryRepository extends BaseRepository
{
    protected $queryFilter;

    public function __construct(Category $_model)
    {
        $this->model = $_model;
        $this->query = $this->model->newQuery();
    }

    #region Basic
    public function get($search = null, $orderBy = null, $orderType = null, $startLimit = null, $endLimit = null)
    {

        
    }


    public function search($search, $criteria){
        //TODO: Implements search method
    }
    
    #endregion
}