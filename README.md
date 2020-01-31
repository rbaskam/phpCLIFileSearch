# Exercise
This should read all the text files in the given directory, building an in memory representation of the files and their contents (think about efficient ways to index the content for searching, what data structures are best suited for search?), and then give a command prompt at which interactive searches can be performed. 

## Ranking 
-	The rank score must be 100% if a file contains all the words 
-	It must be 0% if it contains none of the words 
-	It should be between 0 and 100 if it contains only some of the words ¬ but the exact ranking formula is up to you to choose and implement 

## Things to consider in your implementation 
-	What constitutes a word 
-	What constitutes two words being equal (and matching) 
-	Data structure design: the in memory representation to search against 
-	Ranking score design: start with something basic then iterate as time allows
-	Testability 

## Deliverables 
-	Code to implement a version of the above 
-	Unit tests to demonstrate that the code works and different errors cases are considered
-	A README containing instructions so that we know how to build and run your code


## Usage
execute `./index search /../../tests/Files/`
Type in your search params. i.e not how

The application runs in a loop, until you type `:quit`

## Tests
Execute `./vendor/bin/phpunit`