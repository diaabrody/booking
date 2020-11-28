<?php

namespace App\Http\Resources;

use App\Http\Controllers\ApiResponse\ApiResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use function Clue\StreamFilter\fun;

class ChaletsCollection extends ResourceCollection
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
                    "long"=>$row->long,
                    "lat"=>$row->lat,
                    "location"=>$row->location,
                    "discount"=>$row->discount,
                    "markup"=>$row->markup ,
                    "isActive"=>$row->isActive,
                    "description"=>$row->description,
                    "roomsNumber"=>$row->rooms_number,
                    "bedsNumber"=>$row->beds_number,
                    "floorsNumber"=>$row->floors_number,
                    "bathroomsNumber"=>$row->bathroomsNumber,
                    "capacity"=>$row->capacity,
                    "area"=>$row->area,
                    "view" =>$row->chaletView,
                    "type" =>$row->chaletType,
                    "resort" =>$row->resort,
                    "city" =>$row->city,
                    "createdAt" =>$row->created_at,
                    "updatedAt" =>$row->updated_at,
            ];
        });
        return $this->getResourceCollectionResponseAsArray($chaletsCollection->toArray());
    }
}
