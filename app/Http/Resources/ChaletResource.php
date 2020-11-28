<?php

namespace App\Http\Resources;

use App\Http\Controllers\ApiResponse\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ChaletResource extends JsonResource
{
    use ApiResponse;

    private $default;


    public function __construct($resource, $default = false)
    {
        $this->default = $default;
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $chalet = [
            "id" => $this->id,
            "name" => $this->name,
            "long" => $this->long,
            "lat" => $this->lat,
            "location" => $this->location,
            "discount" => $this->discount,
            "markup" => $this->markup,
            "isActive" => $this->isActive,
            "description" => $this->description,
            "roomsNumber" => $this->rooms_number,
            "bedsNumber" => $this->beds_number,
            "floorsNumber" => $this->floors_number,
            "bathroomsNumber"=>$this->bathroomsNumber,
            "capacity" => $this->capacity,
            "view" => $this->chaletView,
            "type" => $this->chaletType,
            "resort" => $this->resort,
            "city" => $this->city,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
        ];

        if ($this->default)
            return $chalet;
        $result = [$chalet];
        return $this->getResourceCollectionResponseAsArray($result);
    }
}
