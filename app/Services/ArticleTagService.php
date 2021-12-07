<?php

declare(strict_types=1);


namespace App\Services;

use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleTagService
{

    public Article $article;
    public Tag $tag;
    public ArticleTag $articleTag;

    public function __construct()
    {
        $this->article = new Article();
        $this->tag = new Tag();
        $this->articleTag = new ArticleTag();
    }

    public function getAllArticlesWithTags(): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $this->article->with('tags')->get();
            $resData = [
                'status' => 'SUCCESS',
                'data' => $data,
            ];
        } catch (\Exception $e) {
            $resData = [
                'status' => 'ERROR',
                'errors' => $e->getMessage(),
            ];
        }
        return response()->json($resData);
    }

    public function getAllTagsWithArticles()
    {
        return $this->tag->with('articles')->get();
    }

    public function showArticle(int $id)
    {
        $status = 200;

        try {
            $data = $this
                ->article
                ->with('tags')
                ->where('id', $id)
                ->first();

            $resData = [
                'status' => 'SUCCESS',
                'data' => $data,
            ];
        } catch (\Exception $e) {
            $resData = [
                'status' => 'ERROR',
                'errors' => $e->getMessage(),
            ];
            $status = 422;
        }
        return response()->json($resData, $status);
    }

    public function showTag(int $id)
    {
        return $this
            ->tag
            ->with('articles')
            ->where('id', $id)
            ->first();
    }

    public function createArticle(StoreArticleRequest $request)
    {
        $status = 200;

        try {
            $isTitle = $this->article->where('title', $request->title)->first();

            if ($isTitle) {
                $resData = [
                    'status' => 'ERROR',
                    'errors' => 'Title is not unique',
                ];
                $status = 422;
            } else {
                $article = $this->article->create(
                    $request->only(['title', 'content'])
                );

                if ($request->get('tags') && !empty($request->get('tags'))) {
                    $tags = $request->get('tags');

                    foreach ($request->get('tags') as $tag) {
                        $tagId = $this->createOrFindTag($tag);
                        $this->articleTag->create([
                            'article_id' => $article->id,
                            'tag_id' => $tagId,
                        ]);
                    }
                }

                $data = $this
                    ->article
                    ->with('tags')
                    ->where('id', $article->id)
                    ->first();

                $resData = [
                    'status' => 'SUCCESS',
                    'data' => $data,
                ];
            }
        } catch (\Exception $e) {
            $resData = [
                'status' => 'ERROR',
                'errors' => $e->getMessage(),
            ];
            $status = 422;
        }

        return response()->json($resData, $status);
    }

    public function updateArticle(array $request, int $id)
    {
        $status = 200;

        try {
            $article = $this->article->where('id', $id)->first();
            if ($article) {
                $article_changed = false;

                if (isset($request['title']) && !empty($request['title'])) {
                    $article->title = $request['title'];
                    $article_changed = true;
                }

                if (isset($request['content']) && !empty($request['content'])) {
                    $article->content = $request['content'];
                    $article_changed = true;
                }

                if ($article_changed) {
                    $article->update();
                }

                if (isset($request['tags']) && !empty($request['tags'])) {
                    $method = $request['method'] ?: 'add';

                    if ($method === 'replace') {
                        $this->clearTagsInArticle($id);
                    }

                    foreach ($request['tags'] as $tag) {
                        $tagId = $this->createOrFindTag($tag);
                        $isExistsTag = $this->checkExistsTagInArticle($id, $tagId);

                        if (!$isExistsTag) {
                            $this->articleTag->create([
                                'article_id' => $id,
                                'tag_id' => $tagId,
                            ]);
                        }
                    }
                }

                $data = $this
                    ->article
                    ->with('tags')
                    ->where('id', $id)
                    ->first();

                $resData = [
                    'status' => 'SUCCESS',
                    'data' => $data,
                ];
            } else {
                $resData = [
                    'status' => 'ERROR',
                    'errors' => 'Undefined articles index',
                ];
                $status = 422;
            }
        } catch (\Exception $e) {
            $resData = [
                'status' => 'ERROR',
                'errors' => $e->getMessage(),
            ];
            $status = 500;
        }
        return response()->json($resData, $status);
    }

    public function updateArticle1(array $request, int $id)
    {
        $status = 200;

        try {
            $article = $this->article->where('id', $id);
            if ($article) {
                $article_changed = false;

                if ($request->get('title') && !empty($request->get('title'))) {
                    $article->title = $request->get('title');
                    $article_changed = true;
                }

                if ($request->get('content') && !empty($request->get('content'))) {
                    $article->content = $request->get('content');
                    $article_changed = true;
                }

                if ($article_changed) {
                    $article->save();
                }

                if ($request->get('tags') && !empty($request->get('tags'))) {
                    $method = $request->get('method') ?: 'add';

                    if ($method === 'replace') {
                        $this->clearTagsInArticle($id);
                    }

                    foreach ($request->get('tags') as $tag) {
                        $tagId = $this->createOrFindTag($tag);
                        $isExistsTag = $this->checkExistsTagInArticle($id, $tagId);

                        if (!$isExistsTag) {
                            $this->articleTag->create([
                                'article_id' => $id,
                                'tag_id' => $tagId,
                            ]);
                        }
                    }
                }

                $data = $this
                    ->article
                    ->with('tags')
                    ->where('id', $id)
                    ->first();

                $resData = [
                    'status' => 'SUCCESS',
                    'data' => $data,
                ];
            } else {
                $resData = [
                    'status' => 'ERROR',
                    'errors' => 'Undefined articles index',
                ];
                $status = 422;
            }
        } catch (\Exception $e) {
            $resData = [
                'status' => 'ERROR',
                'errors' => $e->getMessage(),
            ];
            $status = 500;
        }
        return response()->json($resData, $status);
    }

    private function clearTagsInArticle(int $article_id): void
    {
        $this
            ->articleTag
            ->where('article_id', $article_id)
            ->delete();
    }

    public function deleteArticle(int $id)
    {
        try {
            $article = $this
                ->article
                ->where('id', $id)
                ->first();

            if ($article) {
                $article->tags()->detach();
                $article->delete();

                $resData = [
                    'status' => 'SUCCESS',
                    'message' => 'Article successfully deleted',
                ];
            } else {
                $resData = [
                    'status' => 'ERROR',
                    'errors' => 'Article not found',
                ];
            }
        } catch (\Exception $e) {
            $resData = [
                'status' => 'ERROR',
                'errors' => $e->getMessage(),
            ];
            $status = 422;
        }

        return response()->json($resData);
    }

    public function deleteTag(int $id)
    {
        try {
            $tag = $this
                ->where('id', $id)
                ->first();

            if ($tag) {
                $tag->articles()->detach();
                $tag->delete();

                $resData = [
                    'status' => 'SUCCESS',
                    'message' => 'Tag successfully deleted',
                ];
            } else {
                $resData = [
                    'status' => 'ERROR',
                    'errors' => 'Tag not found',
                ];
            }
        } catch (\Exception $e) {
            $resData = [
                'status' => 'ERROR',
                'errors' => $e->getMessage(),
            ];
            $status = 422;
        }

        return response()->json($resData);
    }

    public function createTag(StoreTagRequest $request): Tag
    {
        if (empty($request->get('articles'))) {
            $tag = $this->article->create(
                $request->only(['name'])
            );
        } else {
            $tag = $this->article->create(
                $request->only(['name'])
            );

            foreach ($request->get('articles') as $article) {
                $tagId = $this->createOrFindTag($article);
                $this->articleTag->create([
                    'article_id' => $article->id,
                    'tag_id' => $tagId,
                ]);
            }
        }
        return $tag;
    }

    public function createOrFindTag($tag): int
    {
        $isTag = $this->tag::where('name', $tag)->first();

        if ($isTag) {
            return $isTag->id;
        } else {
            $tagCreated = $this->tag->create([
                'name' => $tag
            ]);
            return $tagCreated->id;
        }
    }

    private function checkExistsTagInArticle(int $article_id, int $tag_id): bool
    {
        $tag_ids = $this
            ->articleTag
            ->where('article_id', $article_id)
            ->pluck('tag_id')
            ->toArray();

        return in_array($tag_id, $tag_ids, true);
    }


}
