<?php

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
        $this->call(ActivitiesSeeder::class);
        $this->call(JobsSeeder::class);
        $this->call(ProjectsSeeder::class);
        $this->call(SubprojectsSeeder::class);
        $this->call(WorklogsSeeder::class);
    }
}
