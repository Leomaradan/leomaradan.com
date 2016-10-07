<?php

use Illuminate\Database\Seeder;

class BlogArchive extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@localhost',
            'password' => bcrypt('admin'),
            'status' => 'admin'
        ]);
    }
}
