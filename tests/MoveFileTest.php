<?php

use PHPUnit\Framework\TestCase;

class MoveFileTest extends TestCase{

    /***************************************
     * Test moveMultiple function
     ***************************************/

    /**
     * @throws Exception
     */
    public function testMoveMultipleMissingArrayValue(){
        $this->expectExceptionCode(100);

        $data = [
            [
                'src' => '',
            ]
        ];

        $mv = new \FileTools\MoveFile();
        $mv->moveMultiple($data);
    }

    public function testMoveMultipleBadOutputArrayValue(){
        $this->expectExceptionCode(100);

        copy('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/test_unit.mp4');
        $data = [
            [
                'src'               => 'tests/test_unit.mp4',
                'output'            => 'FAKE_PATH/test_unit.mp4',
                'createOutputPath'  => false,
            ]
        ];

        $mv = new \FileTools\MoveFile();
        $mv->moveMultiple($data);

        unlink('tests/test_unit.mp4');
    }

    public function testMoveMultipleBadSrcArrayValue(){
        $this->expectExceptionCode(100);

        copy('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/test_unit.mp4');
        $data = [
            [
                'src'               => 'tests/FAKE_FILE.mp4',
                'output'            => 'tests/test_unit.mp4',
                'createOutputPath'  => false,
            ]
        ];

        $mv = new \FileTools\MoveFile();
        $mv->moveMultiple($data);

        unlink('tests/test_unit.mp4');
    }

    public function testMoveMultipleBadNameFileOutputArrayValue(){
        $this->expectExceptionCode(100);

        copy('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/test_unit.mp4');
        $data = [
            [
                'src'               => 'tests/test_unit.mp4',
                'output'            => 'tests/INVALID_NAME_FILE',
                'createOutputPath'  => true,
            ]
        ];


        $mv = new \FileTools\MoveFile();
        $mv->moveMultiple($data);

        unlink('tests/test_unit.mp4');
    }

    public function testMoveMultipleCreateOutputPathSuccess(){
        copy('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/test_unit.mp4');
        copy('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/test_unit2.mp4');
        copy('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/test_unit3.mp4');

        $data = [
            [
                'src'               => 'tests/test_unit.mp4',
                'output'            => 'tests/test_unit_rename.mp4',
                'createOutputPath'  => false,
            ],
            [
                'src'               => 'tests/test_unit2.mp4',
                'output'            => 'tests/test_unit_rename_2.mp4',
                'createOutputPath'  => false,
            ],
            [
                'src'               => 'tests/test_unit3.mp4',
                'output'            => 'tests/test_unit_rename_3.mp4',
                'createOutputPath'  => false,
            ],
        ];

        $mv = new \FileTools\MoveFile();
        $result = $mv->moveMultiple($data);

        foreach ($result as $value){
            $this->assertInstanceOf(\FileTools\File::class, $value );
        }

        unlink('tests/test_unit_rename.mp4');
        unlink('tests/test_unit_rename_2.mp4');
        unlink('tests/test_unit_rename_3.mp4');
    }

    public function testMoveMultipleNoCreateOutputPathSuccess(){
        copy('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/test_unit.mp4');
        copy('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/test_unit2.mp4');
        copy('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/test_unit3.mp4');

        $data = [
            [
                'src'               => 'tests/test_unit.mp4',
                'output'            => 'tests/NEW_FOLDER_MULTIPLE/test_unit_rename.mp4',
            ],
            [
                'src'               => 'tests/test_unit2.mp4',
                'output'            => 'tests/NEW_FOLDER_MULTIPLE/test_unit_rename_2.mp4',
            ],
            [
                'src'               => 'tests/test_unit3.mp4',
                'output'            => 'tests/NEW_FOLDER_MULTIPLE/test_unit_rename_3.mp4',
            ],
        ];

        $mv = new \FileTools\MoveFile();
        $result = $mv->moveMultiple($data);

        foreach ($result as $value){
            $this->assertInstanceOf(\FileTools\File::class, $value );
        }

        unlink('tests/NEW_FOLDER_MULTIPLE/test_unit_rename.mp4');
        unlink('tests/NEW_FOLDER_MULTIPLE/test_unit_rename_2.mp4');
        unlink('tests/NEW_FOLDER_MULTIPLE/test_unit_rename_3.mp4');
        rmdir('tests/NEW_FOLDER_MULTIPLE');
    }

    /***************************************
     * Test move function
     ***************************************/

    public function testMoveFileNotExist(){
        $this->expectExceptionCode(101);

        $mv = new \FileTools\MoveFile();
        $mv->move('tests/FAKE_FILE.mp4', 'tests');
    }


    public function testMoveOutputNotExist(){
        $this->expectExceptionCode(102);

        $mv = new \FileTools\MoveFile();
        $mv->move('tests/samples/big_buck_bunny_720p_10mb.mp4', 'FAKE_OUTPUT/test.mp4', false);
    }

    public function testMoveOutputInvalidName(){
        $this->expectExceptionCode(103);

        $mv = new \FileTools\MoveFile();
        $mv->move('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/INVALID_NAME', false);
    }

    public function testMoveCreateOutputPathSuccess(){
        copy('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/test_unit.mp4');
        $mv = new \FileTools\MoveFile();
        $result = $mv->move('tests/test_unit.mp4', 'tests/NEW_FOLDER/test_unit.mp4');

        $this->assertInstanceOf(\FileTools\File::class, $result );

        unlink('tests/NEW_FOLDER/test_unit.mp4');
        rmdir('tests/NEW_FOLDER/');
    }

    public function testMoveNoCreateOutputPathSuccess(){
        copy('tests/samples/big_buck_bunny_720p_10mb.mp4', 'tests/test_unit.mp4');
        $mv = new \FileTools\MoveFile();
        $result = $mv->move('tests/test_unit.mp4', 'tests/test_unit.mp4');

        $this->assertInstanceOf(\FileTools\File::class, $result );

        unlink('tests/test_unit.mp4');
    }
}
