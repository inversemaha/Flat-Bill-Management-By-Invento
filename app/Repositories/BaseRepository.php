<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    protected $query;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->query = $model->newQuery();
    }

    /**
     * Get all records
     */
    public function all()
    {
        $result = $this->query->get();
        $this->resetQuery();
        return $result;
    }

    /**
     * Find record by id
     */
    public function find($id)
    {
        $result = $this->query->find($id);
        $this->resetQuery();
        return $result;
    }

    /**
     * Create new record
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update record
     */
    public function update($id, array $data)
    {
        $record = $this->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    /**
     * Delete record
     */
    public function delete($id)
    {
        $record = $this->find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }

    /**
     * Get paginated records
     */
    public function paginate($perPage = 15)
    {
        return $this->query->paginate($perPage);
    }

    /**
     * Find by specific criteria
     */
    public function findBy($field, $value)
    {
        return $this->query->where($field, $value)->get();
    }

    /**
     * Get records with relationships
     */
    public function with($relations)
    {
        $this->query = $this->query->with($relations);
        return $this;
    }

    /**
     * Add where condition
     */
    public function where($field, $operator = null, $value = null)
    {
        if (func_num_args() == 2) {
            $value = $operator;
            $operator = '=';
        }
        $this->query = $this->query->where($field, $operator, $value);
        return $this;
    }

    /**
     * Count records
     */
    public function count()
    {
        $result = $this->query->count();
        $this->resetQuery();
        return $result;
    }

    /**
     * Check if records exist
     */
    public function exists()
    {
        $result = $this->query->exists();
        $this->resetQuery();
        return $result;
    }

    /**
     * Reset query builder
     */
    protected function resetQuery()
    {
        $this->query = $this->model->newQuery();
    }
}
