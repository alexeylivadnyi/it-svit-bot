<?php


namespace App\Service;


interface DataProvider
{
    public function provide(): \Generator;
}