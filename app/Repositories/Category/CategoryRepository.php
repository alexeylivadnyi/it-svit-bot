<?php


namespace App\Repositories\Category;


use App\Repositories\WithFiltersContract;

interface CategoryRepository extends WithFiltersContract
{
    public function query();

    public function get(array $columns = ['*']);
}
