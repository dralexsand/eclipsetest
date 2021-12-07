<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Article;
use App\Services\ArticleTagService;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    protected ArticleTagService $service;

    public function __construct()
    {
        $this->service = new ArticleTagService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->getAllArticlesWithTags();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        return $this->service->createArticle($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return $this->service->showArticle($id);
    }


    /**
     * @param Request $request
     * @param int $id
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $validate_data = ApiRequest::articleRequestUpdate($request);

        return $validate_data['status'] === 'error' ? $validate_data : $this->service->updateArticle(
            $validate_data['data'],
            $id
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        return $this->service->deleteArticle($id);
    }
}
