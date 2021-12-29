<?php

namespace Database\Seeders;

use App\Models\Posts;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'title' => Str::random(10),
            'body' => Str::random(10),
            'featured_image' => Str::random(5),
            'userid' => 1,
            'categoryid' => 1
        ]);
        // Posts::factory()->count(50)->create();
    }
}
