# Packagist Move files
####  A simple package for get files with extension and move.

#### Required 

* PHP >=7.4

#### Run with docker (branch : docker)

> ./helper install

#### Run unit test

* In folder app :
    > vendor/bin/phpunit tests
                   
    OR
    
   > ./run_test.sh


####

* Install with composer :
 
  > composer require sauvank/file-tools

#### List function

````
MoveFile::move(string $src, string $output, bool $createOutputPath [default : true]): File

* string $src, source of the file to move
* string $output, output of the file
* bool $createOutputPath, default true, if the folder does not exist, create them.

Return instance of File in case of success or Exeption if error
.
````
* $files, multidimensional array.
    * each array need :
        * string 'src', source of the file to move
        * string 'output', output of the file
    * optional :
        * bool 'createOutputPath' default true, if the folder does not exist, create them.


____________

````
MoveFile::moveMultiple(array $files)

````
* $files, multidimentionnal array
    * each array need :
        * string 'src', source of the file to move
        * output 'src', output of the file
    * optional :
        * bool 'createOutputPath' default true, if the folder does not exist, create them.

Return array instance File in case of success or Exeption if error
____________


````
GetFile::byExtension(string $folderPath, array $extsToGet = [], array $excludeFolder = ['\$RECYCLE\.BIN', 'Trash-1000', 'found\.000'])

````
* string $folderPath, path of the folder to get files
* array $extsToGet, array contain extention files to get. ex: ['mkv', 'mp4']
* array $excludeFolder, array contain folder name to exclude.

Return array instance File or Exeption if error
____________



### Exemple : 
 
#### move one files 
 ````
 use FileTools\MoveFile;
 $moveFile = new MoveFile();
 
 try{
     $result = $mv->move('tests/test_unit.mp4', 'tests/test_unit.mp4');
     // instance of File
 }catch (Exception $e){
     var_dump('Catch: ' . $e->getMessage());
 }
 ````
 
#### move multiple files 

> exemple : 

````
use FileTools\MoveFile;
$moveFile = new MoveFile();
$data = [
    [
        'src' => 'tests/samples/fake_mkv.mkv',
        'output' => 'tests/samples/',
        'createOutputPath' => false
    ],
    [
        'src' => 'tests/samples/ii.mkv',
        'output' => 'tests/samples/',
        'createOutputPath' => false
    ],
    [
        'src' => 'tests/samples/fake_mkv.mkv',
        'output' => 'tests/samples/ii/',
        'createOutputPath' => false
    ],
];

try{
    $result = $moveFile->moveMultiple($data);
    // array instance of File
}catch (Exception $e){
    var_dump('Catch: ' . $e->getMessage());
}

````


### Class File function 

````
getDirname(): ?string
````

````
setDirname($dirname): void
````

````
getBasename(): ?string
````

````
setBasename($basename): void
````
````
getExtension(): ?string
````
````
setExtension($extension): void
````
````
getFilename(): ?string
````
````
setFilename($filename): void
````
````
getFullPath(): ?string
````
````
getMimeType(): ?string
````

````
getFileSize():?int
````
````
getLastPath(): ?string
````
````
setLastPath($lastPath): void
````

