<?php


namespace App\Repositories;


interface IRepository
{
    public function all();
    public function findById();
    public function  create();
    public function update();
    public function delete();

}