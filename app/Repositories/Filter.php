<?php


namespace App\Repositories;


interface Filter
{
    public function apply($query);
}
