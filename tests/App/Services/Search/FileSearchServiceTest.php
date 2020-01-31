<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use App\Services\Search\FileSearchService;

final class FileSearchServiceTest extends TestCase
{
    private $fileSearchService;
    
    public function setUp(): void
    {
        $this->fileSearchService = new FileSearchService();
    }

    public function testSearchCanChangeTheCaseSearch(): void
    {
        $expected = true;
        
        $caseSensitive = $this->fileSearchService->setCaseSensitive($expected);
        $caseSensitive = $this->fileSearchService->getCaseSensitive();

        $this->assertEquals($expected, $caseSensitive);
    }

    public function testSearchCanGetTheCaseSearch(): void
    {
        $caseSensitive = $this->fileSearchService->getCaseSensitive();

        $this->assertEquals(false, $caseSensitive);
    }

    public function testSearchCanChangeTheFileExtensionSearch(): void
    {
        $expected = ".pdf";

        $extension = $this->fileSearchService->setExtension($expected);

        $this->assertEquals($expected, $extension);
        
    }

    public function testSearchCanGetTheFileExtensionSearch(): void
    {
        $expected = ".txt";

        $extension = $this->fileSearchService->getExtension();

        $this->assertEquals($expected, $extension);
    }

    public function testSearchCanChangeTheSeparatorSearch(): void
    {
        $expected = "/\W+/";

        $extension = $this->fileSearchService->setSeparator($expected);

        $this->assertEquals($expected, $extension);
        
    }

    public function testSearchCanGetTheSeparatorSearch(): void
    {
        $expected = "/\W+/";

        $extension = $this->fileSearchService->getSeparator();

        $this->assertEquals($expected, $extension);
    }
}