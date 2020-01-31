<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Cli\App;
use App\Command\SearchController;
use App\Services\Search\FileSearchService;

final class SearchControllerTest extends TestCase
{
    private $searchController;
    private $dataFileFolder = "/../../tests/Files/";
    private $args = array('', '', "/../../tests/Files/");
    
    public function setUp(): void
    {
        $app = new App();
        $this->searchController = new SearchController($app, new FileSearchService());
    }

    public function testSearchHasArrayDataThrowException(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $arg = 'string';
        $this->searchController->run($arg);
    }

    public function testSearchCanFindFiles(): void
    {
        $expected = "12 files read in directory /../../tests/Files/". PHP_EOL;
        $this->expectOutputString($expected);

        $this->searchController->findFiles($this->dataFileFolder);
    }
}