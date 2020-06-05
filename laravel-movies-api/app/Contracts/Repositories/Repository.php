<?php

namespace App\Contracts\Repositories;

interface Repository
{
    /**
     * Get all of the models from the database.
     *
     * @param  array  $columns
     * @return mixed
     */
    public function all(array $columns = ['*']);

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  int  $id
     * @param  array  $columns
     * @return mixed
     */
    public function find(int $id, array $columns = ['*']);

    /**
     * Update the model in the database.
     *
     * @param  int  $id
     * @param  array  $attributes
     * @return mixed
     */
    public function update(int $id, array $attributes);

    /**
     * Delete the model from the database.
     *
     * @param  int  $id
     * @return mixed
     */
    public function delete(int $id);
}
