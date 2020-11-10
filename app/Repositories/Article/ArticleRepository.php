<?php
declare(strict_types=1);

namespace App\Repositories\Article;


use App\Repositories\WithFiltersContract;

interface ArticleRepository extends WithFiltersContract
{

    public function query();

    public function get(array $columns = ['*']);
}
