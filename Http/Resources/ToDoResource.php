<?php

namespace ArtisanCloud\ToDoable\Http\Resources;

use ArtisanCloud\SaaSFramework\Http\Resources\BasicResource;
use ArtisanCloud\SaaSFramework\Http\Resources\LandlordResource;


class ToDoResource extends BasicResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $arrayTransformedKeys = transformArrayKeysToCamel($this->resource->getAttributes());
//        dd($arrayTransformedKeys);

        $arrayTransformedKeys["replies"] = new ToDoResource($this->whenLoaded('replies'));

        return $arrayTransformedKeys;

    }
}
