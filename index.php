<?php
require __DIR__ . '/vendor/autoload.php';

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
    $moveFile->moveMultiple($data);
}catch (Exception $e){
    var_dump('Catch: ' . $e->getMessage());
}
