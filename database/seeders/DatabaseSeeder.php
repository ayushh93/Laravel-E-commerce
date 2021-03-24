<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Theme;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::insert([
            'name'=> "Ayush Karmacharya",
            'email' => "ayushkarmacharya220@gmail.com",
            'address'=> "Bhaktapur",
            'password' => bcrypt("password"),
            'phone' => "9843700444",
            'role_id' =>1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Theme::insert([
            'site_title'=> "Hamro Shop",
            'site_subtitle' => "The best e-commerce in town",
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
