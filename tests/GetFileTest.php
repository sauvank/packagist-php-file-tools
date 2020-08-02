<?php declare(strict_types=1);

use FileTools\GetFile;
use PHPUnit\Framework\TestCase;

final class GetFileTest extends TestCase
{
    public function testGoodTotalFiles(): void
    {
        $files = new GetFile();
        $files = $files->getFilesByExt(__DIR__ . '/samples/', ['mp4']);
        $this->assertEquals(2, count($files));
    }

    public function testGoodTotalFilesWith2Exts(): void
    {
        $files = new GetFile();
        $files = $files->getFilesByExt(__DIR__ . '/samples/', ['mp4', 'mkv']);
        $this->assertEquals(4, count($files));
    }

    public function testReturnErrorNotExistingFolder(): void
    {
        $files = new GetFile();
        $files = $files->getFilesByExt(__DIR__ . '/no_exist_folder/', ['mp4']);
        $this->assertTrue($files['error']);
    }

    public function testPathInfoWithBadPath(){
        $files = new GetFile();
        $result = $files->fileInfo(new SplFileInfo('/tmp/foo.txt'));
        $this->assertTrue($result['error']);
    }
}
