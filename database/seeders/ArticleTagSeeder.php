<?php

namespace Database\Seeders;

use App\Helpers\Utils;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $minTags = 3;
        $maxTags = 10;

        $articleIds = Article::pluck('id')->toArray();
        $tagIds = Tag::pluck('id')->toArray();

        foreach ($articleIds as $articleId) {
            $randomTagIds = Utils::UniqueRandomInt(
                1,
                count($tagIds) - 1,
                random_int($minTags, $maxTags)
            );

            foreach ($randomTagIds as $tagId) {
                DB::table('article_tags')->insert([
                    'article_id' => $articleId,
                    'tag_id' => $tagId,
                ]);
            }
        }
    }
}
