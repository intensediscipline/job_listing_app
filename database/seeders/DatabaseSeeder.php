<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // needed to ignore foreign keys
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // truncate tables
        DB::table('job_listings')->truncate();
        DB::table('users')->truncate();
        DB::table('job_user_bookmarks')->truncate();
        DB::table('applicants')->truncate();


        $this->call(TestUserSeeder::class);
        $this->call(RandomUserSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(BookmarkSeeder::class);
    }
}
