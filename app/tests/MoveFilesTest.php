<?php declare(strict_types=1);

use FileTools\MoveFiles;
use PHPUnit\Framework\TestCase;

final class MoveFilesTest extends TestCase
{
    public function testBadPathSrcFile(): void
    {
        $files = new MoveFiles();
        $files = $files->move(__DIR__ . '/FAKE/test_move/', __DIR__ . '/tests/test_move/ffff.mkv');
        $this->assertEquals(true, $files['error']);
    }

    public function testNotOutputFileName(): void
    {
        $files = new MoveFiles();
        $files = $files->move(__DIR__ . '/test_move/test_\'move.mkv', __DIR__ . '/tests/test_move/');
        $this->assertEquals(true, $files['error']);
    }

    public function testCreateDirOutput(): void
    {
        $src = __DIR__ . '/test_move/';
        $srcFileName = 'test_\'move.mkv';

        $outputDir = $src . 'test_dir/';
        $output = $outputDir .'demo.mkv';
        $files = new MoveFiles();
        $files = $files->move($src . $srcFileName, $output);

        $this->assertEquals(false, $files['error']);
        $this->assertEquals(true, is_dir($src));
        $this->assertEquals(true, is_file($output));
        rename($output, $src . $srcFileName);
        rmdir($outputDir);
    }

    public function testReplaceCharNotAllowedByWindowsOutputPath(){
        $files = new MoveFiles();
        $src = __DIR__ . '/test_move/test_\'move.mkv';
        $output = __DIR__ . '/tests/test_move/test_"\'_*_?*_.mkv';
        $files = $files->move($src, $output);
        $this->assertEquals(false, $files['error']);
        rename($files['new_full_path'], $src);
        rmdir(__DIR__ . '/tests/test_move/test_\'__');
        rmdir(__DIR__ . '/tests/test_move');
    }


}