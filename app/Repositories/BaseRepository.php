<?php

namespace App\Repositories;

use App\Enums\TrashedOption;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cookie as CookieAlias;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;
    protected $query;

    #region Abstract

    /**
     * Get data.
     *
     * @param $search
     * @param $orderBy
     * @param $orderType
     * @param $startLimit
     * @param $endLimit
     * @return mixed
     */
    abstract public function get($search = null, $orderBy = null, $orderType = null, $startLimit = null, $endLimit = null);

    /**
     * Search specific data.
     *
     * @param $search
     * @param $criteria
     * @return mixed
     */
    abstract protected function search($search, $criteria);
    #endregion


    /**
     * Get all data.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->model::all();
    }

    /**
     * Count filtered data.
     *
     * @param $attributes
     * @param $search
     * @param $startLimit
     * @param $endLimit
     * @param $trashOption
     * @return mixed
     */
    public function count($attributes = [], $search = '', $startLimit = null, $endLimit = -1, $trashOption = TrashedOption::WITHOUT_TRASH)
    {
        $this->query = $this->customModel ?? $this->model->newQuery();
        $criteria = $this->filter($attributes, $this->query);

        if (!empty($search))
            $criteria = $this->search($search, $criteria);
        if ($endLimit != null && $endLimit != -1) {
            $criteria->skip($startLimit);
            $criteria->take($endLimit);
        }
        return $criteria->count();
    }

    /**
     * Count all data.
     *
     * @return mixed
     */
    public function countAll()
    {
        return $this->model->count();
    }

    /**
     * Create a new model.
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Get all but keep one Eloquent model loaded in memory at a time.
     *
     * @return mixed
     */
    public function cursor()
    {
        return $this->model->cursor();
    }

    /**
     * Delete an existing model.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    /**
     * Force delete an existing model.
     *
     * @param $id
     * @return mixed
     */
    public function forceDelete($id)
    {
        return $this->model->findOrFail($id)->forceDelete();
    }


    /**
     * Check if a record exists given a list of attributes.
     *
     * @param  array  $attributes
     * @return mixed
     */
    public function exists(array $attributes)
    {
        $query = $this->model->newQuery();

        foreach ($attributes as $column => $value) {
            $query->where($column, $value);
        }

        return $query->exists();
    }


    /**
     * @param array $attributes
     * @param $criteria
     * @return mixed
     */
    public function filter(array $attributes, $criteria)
    {
        foreach ($attributes as $key => $value) {
            if (!empty($value))
                $criteria->where($key, $value);
        }
        return $criteria;
    }

    /**
     * Find a model.
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Find a model even if was deleted
     *
     * @param $id
     * @return mixed
     */

    public function findWithTrashed($id)
    {
        return $this->model::withTrashed()->find($id);
    }

    /**
     * Find a model and throw error if it fails.
     *
     * @param $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get the first record that matches the given list of attributes.
     *
     * @param  array  $attributes
     * @param  string  $operator
     * @return mixed
     */
    public function firstWhere(array $attributes, string $operator = '=')
    {
        $query = $this->model->newQuery();

        foreach ($attributes as $key => $value) {
            $query->where($key, $operator, $value);
        }

        return $query->first();
    }

    /**
     * Get a list of records that matches the given list of attributes.
     *
     * @param  array  $attributes
     * @param  string  $operator
     * @return mixed
     */
    public function getWhere(array $attributes, string $operator = '=')
    {
        $query = $this->model->newQuery();

        foreach ($attributes as $key => $value) {
            $query->where($key, $operator, $value);
        }

        return $query->get();
    }

    /**
     * Get data with some given criteria.
     *
     * @param $attributes
     * @param $search
     * @param $orderBy
     * @param $orderType
     * @param $startLimit
     * @param $endLimit
     * @param $trashOption
     * @return mixed
     */
    public function getWithCriteria($attributes = [], $search = '', $orderBy = null, $orderType = null, $startLimit = null, $endLimit = null, $trashOption = TrashedOption::WITHOUT_TRASH)
    {
        $model = $this->model->newQuery();
        $model = $this->filter($attributes, $model);


        if (!empty($search))
            $model = $this->search($search, $model);

        if ($orderBy != null)
            $model->orderByRaw($orderBy . ' ' . $orderType);
        if ($endLimit != null && $endLimit != -1) {
            $model->skip($startLimit);
            $model->take($endLimit);
        }

        return $model->get();
    }

    /**
     * Save the given attributes.
     * Does not need fillable on Model.
     *
     * @param $model
     * @return boolean
     */
    public function save($model)
    {
        return $model->save();
    }

    /**
     * Get all records but select only requested columns.
     *
     * @param array $columns
     * @return mixed
     */
    public function select($columns = [])
    {
        $columns = is_array($columns) ? $columns : func_get_args();

        if (!empty($columns)) {
            $this->model->select($columns);
        }

        return $this->model->get();
    }

    /**
     * Get all records but select distinct only requested columns.
     *
     * @param  array  $columns
     * @return mixed
     */
    public function selectDistinct($columns = [])
    {
        $columns = is_array($columns) ? $columns : func_get_args();

        return $this->model->distinct()->get($columns);
    }

    /**
     * Update a model.
     *
     * @param  array  $attributes
     * @param $id
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        return $this->model->findOrFail($id)->update($attributes);
    }

    /**
     * Update an model with the given attributes
     * or create a new one if it doesn't.
     *
     * @param array $attributes
     * @param array $values
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

}