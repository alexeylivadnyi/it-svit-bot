<?php
declare(strict_types=1);

namespace App\Repositories\Article\Filters;


use App\Repositories\Filter;

final class ByCategory implements Filter
{
    protected int $categoryId;

    /**
     * ByCategory constructor.
     * @param int $categoryId
     */
    public function __construct(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function apply($query)
    {
        $query->where('category_id', $this->categoryId);
    }
}
