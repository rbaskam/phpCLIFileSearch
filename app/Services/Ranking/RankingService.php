<?php

namespace App\Services\Ranking;

use App\Interfaces\Libraries\RankingAlgorithmInterface;

class RankingService
{
    protected $rankingInterface;

    public function __construct(RankingAlgorithmInterface $rankingAlgorithmInterface)
    {
        $this->rankingAlgorithmInterface = $rankingAlgorithmInterface;
    }

    public function rank($indexes, $caseSensitive, $searchText, $separator)
    {
        return $this->rankingAlgorithmInterface->runAlgorithm($indexes, $caseSensitive, $searchText, $separator);
    }
}