<?php

namespace App\Interfaces\Services\Indexing;

interface indexingInterface
{
    public function buildIndex($files, $caseSensitive, $separator);
}