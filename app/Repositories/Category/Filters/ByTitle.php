<?php
declare(strict_types=1);

namespace App\Repositories\Category\Filters;


use App\Repositories\Filter;

final class ByTitle implements Filter
{
    protected string $title;

    /**
     * ByTitle constructor.
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function apply($query)
    {
        $query->where('title', 'like', "%{$this->title}%");
    }
}
