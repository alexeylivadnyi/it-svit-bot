<?php
declare(strict_types=1);

namespace App\Repositories;


interface WithFiltersContract
{
    public function pushFilter(Filter $filter);

    public function applyFilter($query);
}
