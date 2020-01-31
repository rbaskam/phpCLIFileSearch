<?php

namespace App\Services\Search;

use Cli\CommandController;
use App\Interfaces\Services\Search\SearchInterface;

class FileSearchService implements SearchInterface
{
    protected $files;
    protected $extension = '.txt';
    protected $caseSensitive = false;

    //Split on non word characters
    protected $separator = "/\W+/";

    /**
     * Set the case sensitivity on search of the file
     */
    public function setCaseSensitive($caseSensitive)
    {
        $this->caseSensitive = $caseSensitive;
        return $this->caseSensitive;
    }

    /**
     * Get the file case sensitivity on search of the file
     */
    public function getCaseSensitive(): bool
    {
        return $this->caseSensitive;
    }

    /**
     * Set the file extenion we are searching for
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
        return $this->extension;
    }

    /**
     * Get The file extenion we are searching for in the files
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * Set the separator of words on search of the file
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
        return $this->separator;
    }

    /**
     * Get the separator of words on search of the file
     */
    public function getSeparator(): string
    {
        return $this->separator;
    }

    /**
     * Scan the Directory for a set of files.
     *
     * Takes the arguments and gets the files
     * 
     * @param string $path
     */
    public function find($path)
    {
        $this->path = $path;
        // Search for the files
        $this->files = glob($this->path . "/*" . $this->extension);

        if (count($this->files) === 0) {
            // Condition: nothing to search for
            $this->files = [];
        }

        return $this->files;
    }

}