<?php
require __DIR__ . '/vendor/autoload.php';
use FileTools\GetFile;


$fileTools = new GetFile(true);
$files = $fileTools->getFilesByExt(__DIR__ . '/tests/samples', ['mp4','mkv']);
//var_dump($files);
