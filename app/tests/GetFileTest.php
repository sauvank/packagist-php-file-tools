<?php declare(strict_types=1);

use FileTools\GetFile;
use PHPUnit\Framework\TestCase;

final class GetFileTest extends TestCase
{
    public function testGetFilesByExt(): void
    {
        $files = new GetFile();
        $files = $files->getFilesByExt('/', ['mp4']);
    }
}
