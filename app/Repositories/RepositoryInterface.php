<?php
/**
 * Created by PhpStorm.
 * User: rpg1brg
 * Date: 03/10/2018
 * Time: 16:42
 */

namespace App\Repositories;


interface RepositoryInterface
{
    public function all();

    public function count($attributes = [], $search = '', $startLimit = null, $endLimit = -1, $trashOption = TrashedOption::WITHOUT_TRASH);

    public function countAll();

    public function create(array $attributes);

    public function cursor();

    public function delete($id);

    public function forceDelete($id);

    public function exists(array $attributes);

    public function filter(array $attributes, $criteria);

    public function find($id);

    public function findOrFail($id);

    public function findWithTrashed($id);

    public function firstWhere(array $attributes, string $operator = '=');

    public function getWhere(array $attributes, string $operator = '=');

    public function getWithCriteria(
        $attributes = [],
        $search = '',
        $orderBy = null,
        $orderType = null,
        $startLimit = null,
        $endLimit = null,
    
    );

    public function save($model);

    public function select($columns = []);

    public function selectDistinct($columns = []);

    public function update(array $attributes, $id);

    public function updateOrCreate(array $attributes, array $values = []);
}