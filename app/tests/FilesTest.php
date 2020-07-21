<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use sauvank\GetFile;

final class FilesTest extends TestCase
{
    public function testGetFilesByExt(): void
    {
        $files = new GetFile();
        $files->getFilesByExt('/', ['mp4']);
    }
}
