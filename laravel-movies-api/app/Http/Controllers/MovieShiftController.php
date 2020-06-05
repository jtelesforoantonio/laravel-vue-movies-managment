<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\MovieRepositoryInterface;
use App\Http\Requests\MovieShift\StoreRequest;
use App\Http\Requests\MovieShift\UpdateRequest;
use App\Http\Resources\Movie\MovieShift as MovieShiftResource;
use App\Http\Resources\Movie\MovieShiftCollection;
use Illuminate\Http\Response;

class MovieShiftController extends Controller
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
     * @param $id
     * @return MovieShiftCollection
     */
    public function index($id)
    {
        $perPage = request('itemsPerPage', 10);
        $sortField = request('sortField', 'date_time');
        $sortDir = request('sortDir', 'asc');

        return new MovieShiftCollection($this->repository->shifts($id, $perPage, $sortField, $sortDir));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @param $id
     * @return MovieShiftResource
     */
    public function store(StoreRequest $request, $id)
    {
        return new MovieShiftResource($this->repository->createShift($id, $request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return MovieShiftResource
     */
    public function show($id)
    {
        return new MovieShiftResource($this->repository->shift($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return MovieShiftResource
     */
    public function update(UpdateRequest $request, $id)
    {
        return new MovieShiftResource($this->repository->updateShift($id, $request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->repository->deleteShift($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
