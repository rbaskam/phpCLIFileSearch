<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Cli\App;
use App\Command\SearchController;
use App\Libraries\Ranking\BasicSearchAlgorithm;
use App\Services\Search\FileSearchService;
use App\Services\Indexing\IndexFilesService;

final class BasicSearchAlgorithmTest extends TestCase
{
    protected $searchController;
    protected $dataFileFolder = "/../../tests/Files/";
    protected $files;
    protected $basicSearchAlgorithm;
    protected $separator = "/\W+/";
    protected $indexes;
    
    public function setUp(): void
    {
        $app = new App();
        $this->searchController = new SearchController($app, new FileSearchService());
        $this->files = $this->searchController->findFiles($this->dataFileFolder);
        $this->basicSearchAlgorithm = new BasicSearchAlgorithm();

        //Build an Index of all the words in the file
        $indexFiles = new IndexFilesService();

        $this->indexes = $indexFiles->buildIndex($this->files, false, $this->separator);

    }

    public function testRunAlgorithmWithSetData(): void
    {
        
        $results = $this->basicSearchAlgorithm->runAlgorithm($this->indexes, false, 'and', $this->separator);
        $this->assertArrayHasKey('file1.txt', $results);
    }

    public function testSearchForWordCanFindTheWord(): void
    {
        $indexes['filename1.txt']['word'] = 1;
        //Break the text we are searching for into separate words
        $searchWords = preg_split($this->separator, 'word');

        $results = $this->basicSearchAlgorithm->searchForTheWord($searchWords, $indexes);

        $this->assertEquals(1, $results['filename1.txt']);
    }

    public function testSearchForWordRetrunsNothingCantFindTheWord(): void
    {
        $indexes['filename1.txt']['word'] = 1;
        //Break the text we are searching for into separate words
        $searchWords = preg_split($this->separator, 'test');

        $results = $this->basicSearchAlgorithm->searchForTheWord($searchWords, $indexes);

        $this->assertEquals(true, !isset($results['filename1.txt']));
    }

    public function testConvertRankingsToPercentage(): void
    {
        $rankings['filename1.txt'] = 1;
        $searchWords = preg_split($this->separator, 'word');

        $results = $this->basicSearchAlgorithm->convertRankingsToPercentage($searchWords, $rankings);

        $this->assertEquals(100.00, $results['filename1.txt']);
    }
}