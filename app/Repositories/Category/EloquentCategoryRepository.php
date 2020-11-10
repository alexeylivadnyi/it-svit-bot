<?php
declare(strict_types=1);

namespace App\Repositories\Category;


use App\Models\Category;
use App\Repositories\WithFilters;

class EloquentCategoryRepository implements CategoryRepository
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
        return Category::query();
    }
}
