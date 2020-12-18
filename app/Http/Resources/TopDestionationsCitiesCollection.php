<?php

namespace App\Http\Resources;

use App\Http\Controllers\ApiResponse\ApiResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TopDestionationsCitiesCollection extends ResourceCollection
{
    use ApiResponse;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $chaletsCollection = $this->collection->map(function ($row){
            return  [
                "id"=>$row->id,
                "name"=>$row->name,
                "resortsCount"=>$row->resorts_count,
                "chaletsCount"=>$row->chalets_count,
            ];
        });
        return $this->getResourceCollectionResponseAsArray($chaletsCollection->toArray());
    }

}
