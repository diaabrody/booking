<?php


namespace App\Repositories;


interface IRepository
{
    public function all($filters = [] , $orderBy = array());
    public function findById($id);
    public function create(array $arr);
    public function update( $id , array  $arr);
    public function delete($id);
    public function set($model);
    public function get();

}