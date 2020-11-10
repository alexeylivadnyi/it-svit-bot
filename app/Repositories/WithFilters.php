<?php
declare(strict_types=1);

namespace App\Repositories;



use Illuminate\Support\Collection;

trait WithFilters
{
    private ?Collection $filters = null;

    public function pushFilter(Filter $filter): void
    {
        if (!$this->filters) {
            $this->filters = new Collection();
        }

        $this->filters->push($filter);
    }

    public function applyFilter($query): void
    {
        if (!$this->filters) {
            return;
        }

        foreach ($this->filters as $filter) {
            $filter->apply($query);
        }
    }
}
