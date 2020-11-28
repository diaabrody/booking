<?php


namespace App\Filters;



use App\Repositories\Interfaces\Chalet\IChaletRepository;
use Illuminate\Http\Request;

class Filters
{
    protected $filters = [];

    public $request ;
    protected $builder;

    /**
     * Filters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request=$request;
    }


    public function apply($builder){
        $this->builder = $builder;

        foreach ($this->getFilters() as $cmd => $parameter){
                $method = $this->filters[$cmd];
                if (method_exists($this , $method)){
                    $this->$method($parameter);
                }
        }

        return  $this->builder ;
    }

    private function getFilters(){
       return $this->request->only(array_keys($this->filters));
    }
}