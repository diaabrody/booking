<?php

use Illuminate\Database\Seeder;

class ChaletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Chalet::class ,50)->create();
    }
}
