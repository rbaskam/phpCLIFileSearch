<?php

namespace App\Interfaces\Services\Ranking;

interface RankingInterface
{
    public function rank($indexes, $caseSensitive, $searchText, $separator);
}