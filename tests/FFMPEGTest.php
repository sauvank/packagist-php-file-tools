<?php

use FileTools\FFMPEG;
use PHPUnit\Framework\TestCase;

class FFMPEGTest extends TestCase{

    public function testFileNotExist(){
        $this->expectExceptionCode(106);
        $ffmpeg = new FFMPEG();
        $ffmpeg->setMetadata('tests/FAKE_FILE.mp4', ['title' => 'test title']);
    }

    public function testSetMetadataSuccess(){
        copy('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/test_ffmpeg_unit.mp4');
        $ffmpeg = new FFMPEG();
        $isSuccess = $ffmpeg->setMetadata('tests/test_ffmpeg_unit.mp4', ['title' => 'test title']);
        $this->assertTrue($isSuccess, true);
    }

    public function testSetMetadataSpecialCharInName(){
        copy('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/test_ffmpeg_\'unit.mp4');
        $ffmpeg = new FFMPEG();
        $isSuccess = $ffmpeg->setMetadata('tests/test_ffmpeg_\'unit.mp4', ['title' => 'test title\' special char']);
        $this->assertTrue($isSuccess, true);
        unlink('tests/test_ffmpeg_\'unit.mp4');
    }

    public function testSetMetadataCommentToMkv(){
        copy('tests/samples/SampleVideo_1280x720_1mb.mkv', 'tests/test_ffmpeg_mkv.mkv');
        $ffmpeg = new FFMPEG();
        $isSuccess = $ffmpeg->setMetadata('tests/test_ffmpeg_mkv.mkv', ['comment' => 'test comment']);
        $this->assertTrue($isSuccess, true);
    }

    public function testReadMetadataCommentMKVSuccess(){
        $ffmpeg = new FFMPEG();
        $comment = $ffmpeg->readMetadata('tests/test_ffmpeg_mkv.mkv', 'comment');
        $this->assertEquals('test comment', $comment);
        unlink('tests/test_ffmpeg_mkv.mkv');
    }


    public function testReadMetadataSuccess(){
        $ffmpeg = new FFMPEG();
        $title = $ffmpeg->readMetadata('tests/test_ffmpeg_unit.mp4', 'title');
        $this->assertEquals('test title', $title);
    }

    public function testReadMetadataNoExist(){
        $ffmpeg = new FFMPEG();
        $result = $ffmpeg->readMetadata('tests/test_ffmpeg_unit.mp4', 'NO_EXIST');
        $this->assertFalse($result);
        unlink('tests/test_ffmpeg_unit.mp4');
    }

    public function testGetAllMetadataSuccess(){
        copy('tests/samples/SampleVideo_1280x720_1mb.mkv', 'tests/test_ffmpeg_getmetadata.mkv');

        $ffmpeg = new FFMPEG();
        $ffmpeg->setMetadata('tests/test_ffmpeg_getmetadata.mkv', ['title' => 'test title', 'comment' => 'test comment']);

        $result = $ffmpeg->getAllMetadata('tests/test_ffmpeg_getmetadata.mkv');
        $this->assertEquals(3, count($result));
        unlink('tests/test_ffmpeg_getmetadata.mkv');
    }

}
