<?php

namespace App\Interfaces\Libraries;

interface RankingAlgorithmInterface
{
    public function runAlgorithm($indexes, $caseSensitive, $searchText, $separator);
}