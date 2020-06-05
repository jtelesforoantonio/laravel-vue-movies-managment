<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\MovieRepositoryInterface;
use App\Http\Requests\Movie\StoreRequest;
use App\Http\Requests\Movie\UpdateRequest;
use App\Http\Resources\Movie\Movie as MovieResource;
use App\Http\Resources\Movie\MovieCollection;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    /**
     * @var MovieRepositoryInterface
     */
    private $repository;

    public function __construct(MovieRepositoryInterface $repository)
    {
        $this->middleware('auth:api');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return MovieCollection
     */
    public function index()
    {
        $perPage = request('itemsPerPage', 10);
        $sortField = request('sortField', 'name');
        $sortDir = request('sortDir', 'asc');
        
        return new MovieCollection($this->repository->paginate($perPage, $sortField, $sortDir));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return MovieResource
     */
    public function store(StoreRequest $request)
    {
        $movie = $this->repository->create($request->all());

        return new MovieResource($movie);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return MovieResource
     */
    public function show($id)
    {
        $movie = $this->repository->find($id);

        return new MovieResource($movie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return MovieResource
     */
    public function update(UpdateRequest $request, $id)
    {
        $movie = $this->repository->update($id, $request->all());

        return new MovieResource($movie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->repository->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
