<?php

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Administrator::count() == 0) {
            $this->call(\Encore\Admin\Auth\Database\AdminTablesSeeder::class);
        }
    }
}
