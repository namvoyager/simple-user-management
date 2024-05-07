<?php

namespace VoyagerInc\SimpleUserManagement\Contracts;

interface UserRepository
{
    /**
     * Get a list of the user with pagination.
     */
    public function getWithPagination(array $filters = [], array $columns = ['*']);

    /**
     * Get a specified user.
     */
    public function find($id, array $columns = ['*']);

    /**
     * Handle create a new user.
     */
    public function create(array $data);

    /**
     * Handle update a specified user.
     */
    public function update(array $data, $id);

    /**
     * Handle delete a specified user.
     */
    public function delete($id);
}
