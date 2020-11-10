<?php
declare(strict_types=1);

namespace App\Repositories\Article\Filters;


final class ByLink implements \App\Repositories\Filter
{
    protected string $link;

    public function __construct(string $link)
    {
        $this->link = $link;
    }

    public function apply($query)
    {
        $query->where('link', 'like', "%{$this->link}%");
    }
}
