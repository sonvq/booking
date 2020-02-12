<?php

namespace Modules\Email\Database\Seeders;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class EmailDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
    }
}
