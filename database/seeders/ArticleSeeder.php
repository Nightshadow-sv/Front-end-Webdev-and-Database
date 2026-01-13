<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $tech = Genre::where('name', 'Technology')->first();
        if (!$tech) return;

        Article::create([
            'genre_id'     => $tech->id,
            'title'        => 'New AI Breakthrough Transforms Natural Language Processing',
            'summary'      => 'Researchers announce a significant advancement in language models, improving context understanding by 40%.',
            'content'      => '<p>This is the full article content for testing purposes...</p>',
            'status'       => 'Published',
            'published_at' => Carbon::now(),
            'author_name'  => 'Sarah Chen',
            'featured_image' => '/assets/images/test-ai.jpg',
        ]);
    }
}