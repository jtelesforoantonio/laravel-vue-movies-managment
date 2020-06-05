<?php

namespace App\Repositories;

use App\Contracts\Repositories\MovieRepositoryInterface;
use App\Models\Movie;
use App\Models\MovieShift;

class MovieRepository implements MovieRepositoryInterface
{
    /**
     * @var Movie
     */
    private $model;

    public function __construct(Movie $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function all(array $columns = ['*'])
    {
        return $this->model->all($columns);
    }

    /**
     * Pagination.
     *
     * @param  int  $perPage
     * @param  string  $sortField
     * @param  string  $sortDir
     * @param  string|null  $search
     * @return mixed
     */
    public function paginate(int $perPage = 15, string $sortField = 'name', string $sortDir = 'asc', ?string $search = null)
    {
        return $this->model
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->orWhere('name', 'LIKE', "%$search%")
                        ->orWhere('last_name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")
                        ->orWhere('status', 'LIKE', "%$search%");
                });
            })
            ->when($sortField, function ($query, $sortField) use ($sortDir) {
                return $query->orderBy($sortField, $sortDir);
            })
            ->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function find(int $id, array $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $attributes)
    {
        $movie = $this->find($id);
        $movie->fill($attributes)->save();

        return $movie;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id)
    {
        $movie = $this->find($id);

        return $movie->delete();
    }

    /**
     * Paginate shifts for the given movie.
     *
     * @param  int  $id
     * @param  int  $perPage
     * @param  string  $sortField
     * @param  string  $sortDir
     * @param  string|null  $search
     * @return mixed
     */
    public function shifts(int $id, int $perPage = 15, string $sortField = 'date_time', string $sortDir = 'desc', ?string $search = null)
    {
        return $this->find($id)->shifts()
                    ->when($search, function ($query, $search) {
                        return $query->where(function ($query) use ($search) {
                            $query->orWhere('date_time', 'LIKE', "%$search%")
                                ->orWhere('status', 'LIKE', "%$search%");
                        });
                    })
                    ->when($sortField, function ($query, $sortField) use ($sortDir) {
                        return $query->orderBy($sortField, $sortDir);
                    })
                    ->paginate($perPage);
    }

    /**
     * Create a new shift for the given movie.
     *
     * @param  int  $id
     * @param  array  $attributes
     * @return mixed
     */
    public function createShift(int $id, array $attributes)
    {
        return $this->find($id)->shifts()->create($attributes);
    }

    /**
     * Return a shift.
     *
     * @param  int  $id
     * @return mixed
     */
    public function shift(int $id)
    {
        return MovieShift::findOrFail($id);
    }

    /**
     * Update a shift.
     *
     * @param  int  $id
     * @param  array  $attributes
     * @return mixed
     */
    public function updateShift(int $id, array $attributes)
    {
        $shift = MovieShift::findOrFail($id);
        $shift->fill($attributes)->save();

        return $shift;
    }

    /**
     * Delete a shift.
     *
     * @param  int  $id
     * @return mixed
     */
    public function deleteShift(int $id)
    {
        $shift = MovieShift::findOrFail($id);

        return $shift->delete();
    }
}
