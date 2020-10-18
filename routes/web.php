<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/csss', function () {

    $subQuery = 'SELECT chalet_id FROM chalet_reservations WHERE NOT( end_date< "2020-10-15 " OR start_date >"2020-10-18")';
    dd( DB::select($subQuery));

   // $query= \App\Chalet::whereNotIn('id' , DB::select($subQuery))->get();
    //dd($query);sss
});
