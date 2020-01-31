<?php

namespace App\Interfaces\Services\Search;

interface SearchInterface
{
    public function getCaseSensitive();
    public function setCaseSensitive($caseSensitive);
    public function find($path);
}