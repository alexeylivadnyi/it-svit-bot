<?php
declare(strict_types=1);

namespace App\Repositories\Article;


use App\Models\Article;
use App\Repositories\WithFilters;

class EloquentArticleRepository implements ArticleRepository
{
    use WithFilters;

    public function get(array $columns = ['*'])
    {
        $query = $this->query();

        $this->applyFilter($query);

        return $query->get($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*'])
    {
        $query = $this->query();

        $this->applyFilter($query);

        return $query->paginate($perPage, $columns);
    }

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return Article::query();
    }
}
