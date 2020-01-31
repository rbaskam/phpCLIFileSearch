<?php

namespace App\Command;

use Cli\CommandController;
use App\Interfaces\Command\SearchInterface;
use App\Services\Ranking\RankingService;
use App\Services\Indexing\IndexFilesService;
use App\Libraries\Ranking\BasicSearchAlgorithm;

class SearchController extends CommandController implements SearchInterface
{   
    protected $files;

    /**
     * Initial Load of the search
     *
     * Takes the arguments passed by the user and runs
     * 
     * @param array $argv
     */
    public function run($argv)
    {
        //Check if its an array
        if (!is_array($argv)) {
            throw new \UnexpectedValueException('Var should be an array.');
        }

        //Check if its an array
        if (count($argv) != 3) {
            throw new \UnexpectedValueException('Array should have 3 arguments.');
        }

        $fileLocation = $argv[2];
        //Get all the files in the folder
        $this->files = $this->findFiles($fileLocation);

        $caseSensitive = $this->searchInterface->getCaseSensitive();
        $separator = $this->searchInterface->getSeparator();

        //Get the ranking Service and pass in the algorithm we want to use
        $rankingService = new RankingService(new \App\Libraries\Ranking\BasicSearchAlgorithm());
        
        //Build an Index of all the words in the file
        $indexFiles = new IndexFilesService();
        $indexes = $indexFiles->buildIndex($this->files, $caseSensitive, $separator);

        do {
            $search = readline("search> ");
            $search = trim($search);
            
            if (strlen($search) > 0) {
                // When typed we quit the application
                if ($search === ":quit") {
                    break;
                } else {
                    $results = $rankingService->rank($indexes, $caseSensitive, $search, $separator);

                    if (count($results) === 0) {
                        // There are no matches in the file
                        echo "   No matches found" . PHP_EOL;
                    } else {
                        // We have found some files with the text ouput there result
                        foreach ($results as $file => $ranking) {
                            $ranking = str_pad($ranking, 2, " ", STR_PAD_LEFT);
                            echo $file . " : " . $ranking . "%". PHP_EOL;
                        }
                    }
                }
            }
    
        } while (true);
    }

    /**
     * Get the data we need to search
     * 
     * @param array $argv
     */
    public function findFiles($fileLocation)
    {
        $files = $this->searchInterface->find(__DIR__ . $fileLocation);
        
        //Output the number of files in the directory
        $this->getApp()->getPrinter()->display(count($files) . " files read in directory " . $fileLocation. PHP_EOL);

        return $files;
    }

    
}