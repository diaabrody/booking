<?php

namespace App\Http\Resources;

use App\Http\Controllers\ApiResponse\ApiResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ChaletRatingCollection extends ResourceCollection
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
                "rating"=>$row->rating,
//              "chaletId"=>(new ChaletResource($row->ratable()->first() ,  true )),
                "chaletId"=>$row->ratable_id,
                "createdAt" =>$row->created_at,
                "updatedAt" =>$row->updated_at
            ];
        });

        $result= ["data"=>$chaletsCollection->toArray()];
        return $this->getResourceCollectionResponseAsArray($result);

    }
}
