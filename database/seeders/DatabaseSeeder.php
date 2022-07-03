<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(MetricSeeder::class);
        $this->call(EventCategorySeeder::class);
        $this->call(EventSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(BadgeSeeder::class);
        $this->call(PointRuleSeeder::class);
        $this->call(MailSeeder::class);
        $this->call(LevelsSeeder::class);
        $this->call(QuestionnaireSeeders::class);
        $this->call(LeaderboardSeeder::class);


    }
}
