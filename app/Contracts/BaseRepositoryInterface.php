<?php

namespace App\Contracts;

interface BaseRepositoryInterface
{
    /**
     * Get all records
     */
    public function all();

    /**
     * Find record by id
     */
    public function find($id);

    /**
     * Create new record
     */
    public function create(array $data);

    /**
     * Update record
     */
    public function update($id, array $data);

    /**
     * Delete record
     */
    public function delete($id);

    /**
     * Get paginated records
     */
    public function paginate($perPage = 15);

    /**
     * Find by specific criteria
     */
    public function findBy($field, $value);

    /**
     * Get records with relationships
     */
    public function with($relations);
}
