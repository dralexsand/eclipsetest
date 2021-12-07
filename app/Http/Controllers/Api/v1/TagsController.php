<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\ArticleTagService;
use Illuminate\Http\Request;

class TagsController extends Controller
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
        return $this->service->getAllTagsWithArticles();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\Response|object
     */
    public function show(int $id)
    {
        return $this->service->showTag($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        if ($request->get('name') && $request->get('name') !== '') {
            $tag = $this->service->tag->where('id', $id)->first();
            $tag->update([
                'name' => $request->get('name')
            ]);
        }

        return $this->service->showTag($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        return $this->service->deleteTag($id);
    }
}
