<?php
declare(strict_types=1);

namespace App\Repositories\Article\Filters;


use Carbon\Carbon;

final class ByDate implements \App\Repositories\Filter
{
    protected ?Carbon $date;

    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    public function apply($query)
    {
        $query->where('date', $this->date);
    }
}
