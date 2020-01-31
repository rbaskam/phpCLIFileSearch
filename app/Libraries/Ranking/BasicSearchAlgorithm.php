<?php
    
namespace App\Libraries\Ranking;

use App\Interfaces\Libraries\RankingAlgorithmInterface;


class BasicSearchAlgorithm implements RankingAlgorithmInterface
{

    protected $rankings = [];
    protected $limitOfResults = 10;

    /**
     * The algorithm we use to rank the search in files
     */
    public function runAlgorithm($indexes, $caseSensitive, $searchText, $separator)
    {
        //Start all files with a 0 ranking
        foreach ($indexes as $key => $index) {
            //Put the filename as the ranking index
            $this->rankings[$key] = 0;
        }
 
        //Check the text we are searching for is in the correct case
        if (!$caseSensitive) {
            $searchText = strtolower($searchText);
        }

        //Break the text we are searching for into separate words
        $searchWords = preg_split($separator, $searchText);
        
        //See if the word is in the file
        $this->searchForTheWord($searchWords, $indexes);

        //Convert the results to a percentage
        $this->rankings = $this->convertRankingsToPercentage($searchWords, $this->rankings);

        //Sort then in asceding order
        arsort($this->rankings);

        // Set the limit
        $this->rankings = array_slice($this->rankings, 0, $this->limitOfResults);

        //Return
        return $this->rankings;
    }


    public function searchForTheWord($searchWords, $indexes)
    {

        //Search the indexes for the word
        foreach ($indexes as $key => $index) {
            //Loop through all the cords in the file index
            foreach ($searchWords as $searchAbleWord) {
                
                //If the word matches one of the inputted words add to the ranking
                if (array_key_exists($searchAbleWord, $index)) {
                    //Check we have the key or build one
                    if (isset($this->rankings[$key])) {
                        $this->rankings[$key]++;
                    } else {
                        $this->rankings[$key] = 1;
                    }
                }
            }
        }
        return $this->rankings;
    }

    public function convertRankingsToPercentage($searchWords, $rankings)
    {
        //Get the number of search words
        $numberOfWords = count($searchWords);
        
        if ($numberOfWords == 0) {
            throw new \UnexpectedValueException('There should be words searched.');
        } else {
            foreach ($rankings as $file => $wordsPresent) {
                $precentageRanking = 100 * $wordsPresent / $numberOfWords;
                $rankings[$file] = number_format(round($precentageRanking, 2), 2);
            }
        }
       

        return $rankings;
    }
}