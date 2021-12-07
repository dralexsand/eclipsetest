<?php

declare(strict_types=1);


namespace App\Services;

use App\Models\Article;

class ArticleService
{
    protected Article $model;

    public function __construct()
    {
        $this->model = new Article();
    }

    public function getModel(){

    }
}
