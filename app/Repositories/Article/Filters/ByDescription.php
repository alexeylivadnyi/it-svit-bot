<?php
declare(strict_types=1);

namespace App\Repositories\Article\Filters;


final class ByDescription implements \App\Repositories\Filter
{
    protected string $text;

    /**
     * ByDescription constructor.
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function apply($query)
    {
        $query->where('description', 'like', "%{$this->text}%");
    }
}
