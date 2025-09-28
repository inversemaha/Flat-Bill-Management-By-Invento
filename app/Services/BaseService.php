<?php

namespace App\Services;

use App\Contracts\BaseRepositoryInterface;

abstract class BaseService
{
    protected $repository;

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all records
     */
    public function getAll()
    {
        return $this->repository->all();
    }

    /**
     * Get paginated records
     */
    public function getPaginated($perPage = 15)
    {
        return $this->repository->paginate($perPage);
    }

    /**
     * Find record by id
     */
    public function findById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Create new record
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Update record
     */
    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete record
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
