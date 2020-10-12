<?php
use PHPUnit\Framework\TestCase;

class GetFileTest extends TestCase{

    private $tmpFolder = 'tests/TEST_GET_FILE/';
    private $nbrMkvFile = 3;
    private $nbrAviFile = 5;
    private $nbrMp4File = 2;

    public function testGetAllFileSuccess(){
        $this->createTestFiles();

        $gf = new \FileTools\GetFile();
        $files = $gf->byExtension($this->tmpFolder);
        $this->assertEquals(count($files), $this->nbrMkvFile + $this->nbrAviFile + $this->nbrMp4File);
    }

    public function testGetMKVFileSuccess(){
        $gf = new \FileTools\GetFile();
        $files = $gf->byExtension($this->tmpFolder, ['mkv']);
        $this->assertEquals(count($files), $this->nbrMkvFile);
    }

    public function testGetAVIMKVFileSuccess(){
        $gf = new \FileTools\GetFile();
        $files = $gf->byExtension($this->tmpFolder, ['mkv','avi']);
        $this->assertEquals(count($files), $this->nbrMkvFile+$this->nbrAviFile);
    }

    public function testRemoveTmpFiles(){
        $this->removeTestFiles();
        $this->assertTrue(true);
    }

    private function createTestFiles(){
        mkdir($this->tmpFolder);

        $nbrMkvFile = 3;
        $nbrAviFile = 5;
        $nbrMp4File = 2;

        for ($i = 0; $i < $nbrMkvFile; $i++){
            copy('tests/samples/SampleVideo_360x240_20mb.mkv',$this->tmpFolder ."video$i.mkv");
        }
        for ($i = 0; $i < $nbrAviFile; $i++){
            copy('tests/samples/file_example_AVI_480_750kB.avi',$this->tmpFolder . "video$i.avi");
        }
        for ($i = 0; $i < $nbrMp4File; $i++){
            copy('tests/samples/big_buck_bunny_720p_10mb.mp4',$this->tmpFolder . "video$i.mp4");
        }
    }

    private function removeTestFiles(){
        for ($i = 0; $i < $this->nbrMkvFile; $i++){
            unlink($this->tmpFolder ."video$i.mkv");
        }
        for ($i = 0; $i < $this->nbrAviFile; $i++){
            unlink($this->tmpFolder . "video$i.avi");
        }
        for ($i = 0; $i < $this->nbrMp4File; $i++){
            unlink($this->tmpFolder . "video$i.mp4");
        }
        rmdir($this->tmpFolder);
    }
}
