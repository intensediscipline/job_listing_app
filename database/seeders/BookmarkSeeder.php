<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Job;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get test user
        $testuser = User::where("email", "test@test.com")->firstOrFail();

        // get all job ids
        $jobIds = Job::pluck("id")->toArray();

        // randomly select jobs to bookmark
        $randomJobIds = array_rand($jobIds, 3);

        // attach the selected jobs as bookmarks for the testuser
        foreach ($randomJobIds as $jobId) {
            $testuser->bookmarkedJobs()->attach($jobIds[$jobId]);
        }
    }
}
