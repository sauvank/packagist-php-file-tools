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

* Insall with composer :
 
  > composer require sauvank/file-tools
  
* Get file by extension :

````
 use FileTools\GetFile;
 
 // Get All file with extension 'mp4' in folder+
 // If mime type file not equal the extension file return a warning.
 $callback = $files = $files->getFilesByExt('My/Path/Files', ['mp4']);
````


* Move files 


````
 use FileTools\MoveFiles;
 
$moveFiles = new MoveFiles();

$srcFile = __DIR__ . '/myFolder/file.txt';
$outputPath = __DIR__ . '/myOtherFolder/fileRename.txt';
$callback = $files->move($srcFile, $outputPath);
````

By default, the function 'move' create the folder output if not exist.
If you don't want to create the folder if it doesn't exist: pass false on the three params: 

````
$callback = $files->move($srcFile, $outputPath, false);
````

##### Todo

* Move multiple file.
* Create option for log file move.
