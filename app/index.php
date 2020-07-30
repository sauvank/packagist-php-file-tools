<?php
require __DIR__ . '/vendor/autoload.php';
use FileTools\MoveFiles;


$fileTools = new MoveFiles();
$files = $fileTools->move(__DIR__ . '/tests/test_move/', __DIR__ . '/tests/test_move/ggg.mkv');
var_dump($files);
