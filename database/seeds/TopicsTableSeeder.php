<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        $topics = factory(Topic::class)->times(100)->make();

        Topic::insert($topics->toArray());
    }

}

