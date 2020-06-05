<?php

namespace App\Http\Resources\Movie;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieShift extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['date'] = $this->date_time->format('Y-m-d');
        $data['time'] = $this->date_time->format('H:i');

        return $data;
    }
}
