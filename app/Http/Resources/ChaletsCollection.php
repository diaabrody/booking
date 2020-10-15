<?php

namespace App\Http\Resources;

use App\Http\Controllers\ApiResponse\ApiResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
        $result = [
            'data'=>$this->collection,
        ];
        return $this->getResoueceCollectionResponse($result);
    }
}
