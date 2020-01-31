<?php

namespace App\Services\Indexing;


class IndexFilesService
{
    protected $rankingInterface;
    protected $indices = [];
    protected $caseSensitive;
    protected $separator;

    public function buildIndex($files, $caseSensitive, $separator)
    {
        //Make sure the indeces are empty
        $this->indices       = [];
        $this->caseSensitive = $caseSensitive;
        $this->separator     = $separator;

        for ($i = 0; $i < count($files); $i++) {
            // Create an index for each file
            $this->createIndex($files[$i]);
        }

        return $this->indices;
    }

    public function createIndex($file)
    {
        $handle = fopen($file, "r");
        
        //Get the name of the file
        $name = basename($file);

        //Create a index with the filename
        $this->indices[$name] = [];

        if ($handle) {
            $lineCount = 0;
            while (($line = fgets($handle)) !== false) {

                // Pre-process the line according to our preferences
                if (!$this->caseSensitive) {
                    // Put to lower case if not required
                    $line = strtolower($line);
                }

                // Separate the line into and array 
                $words = preg_split($this->separator, $line);
                $pointer = 0;

                foreach ($words as $word) {
                    //Remove any whitespace
                    $word  = trim($word);

                    if (strlen($word) > 0) {
                        // This is not empty word

                        //Check if we have the word in the index
                        if (isset($this->indices[$name][$word])) {
                            /**
                             * We can use this to get the number of time the 
                             * word is in the file, can be used to increse ranking
                             */
                            $this->indices[$name][$word]++;
                        } else {
                            $this->indices[$name][$word] = 1;
                        }
                    }
                }
            }
        }
    }

}