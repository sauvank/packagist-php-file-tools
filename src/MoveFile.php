<?php
namespace FileTools;
use FileTools\ErrorMsg;

class MoveFile{

    private ErrorMsg $errorMsg;

    public function __construct()
    {
        $this->errorMsg = new ErrorMsg();
    }

    /**
     * Move one file from src path to out path, create the folder if is not exist.
     * @param string $src
     * @param string $output
     * @param bool $createOutputPath
     * @param bool $windowsNameValid, change the name to be valid for windows
     * @return File
     * @throws \Exception
     */
    public function move(string $src, string $output, bool $createOutputPath = true,$windowsNameValid = true):File {
        if($windowsNameValid){
            $output = $this->replaceNotAllowedCharWindows($output);
        }

        $outputDir = dirname($output);
        $outputFileName = basename($output);

        if(!is_file($src)){
            throw new \Exception("File $src not exist", 101);
        }

        if(!$this->checkValidFileName($outputFileName)){
            throw new \Exception("$output does not contain a valid filename.", 103);
        }

        if(!is_dir($outputDir) && !$createOutputPath){
            throw new \Exception("Folder $output not exist, if you want to create it automatically, pass the 3rd argument to true.", 102);
        }

        if($createOutputPath && !is_dir($outputDir)){
            mkdir($outputDir, 0777,true);
        }

        $isMove = rename($src, $output);

        if(!$isMove){
            throw new \Exception("Error to move file", 104);
        }

        $pathInfo = pathinfo($output);
        $file = new File();
        $file->setBasename($pathInfo['basename']);
        $file->setDirname($pathInfo['dirname']);
        $file->setExtension($pathInfo['extension']);
        $file->setFilename($pathInfo['filename']);
        $file->setLastPath($src);
        return $file;
    }

    /**
     * move multiple files.
     * @param array $dataMove multidimensional array, need key [src:string, output:string, optional : createOutputPath:bool ]
     * @return array of file instance. each index array contain a instance of the File with data.
     * @throws \Exception
     */
    public function moveMultiple(array $dataMove):array {

        $output = [];

        $error = $this->checkParamsMove($dataMove);

        if($error->hasError()){
            throw new \Exception(implode("\n", $error->getAllMessage()), 100);
        }

        foreach ($dataMove as $data){
            $createOutputPath = isset($data['createOutputPath']) ? $data['createOutputPath'] : true;
            $output[] = $this->move($data['src'], $data['output'], $createOutputPath);
        }

        return $output;
    }

    /**
     * Check params value for the function 'moveMultiple'
     * @param array $params
     * @return \FileTools\ErrorMsg
     */
    private function checkParamsMove(array $params):ErrorMsg{
        $requiredKeys = ['src', 'output'];

        foreach ($params as $key => $param){
            foreach ($requiredKeys as $requiredKey){

                if(!array_key_exists($requiredKey, $param)){
                    $this->errorMsg->addMsg("in array index $key, missing key '$requiredKey' params in array index $key");
                }

                if(isset($param['output']) && !is_file($param['src'])){
                    $this->errorMsg->addMsg("in array index $key, File ".$param['src']." not exist");
                }

                if((isset($param['output']) && !is_dir(dirname($param['output']))) && (isset($param['createOutputPath']) && !$param['createOutputPath'])){
                    $this->errorMsg->addMsg("in array index $key, Folder ".$param['output']." not exist, if you want to create it automatically, pass the 3rd argument to true.");
                }

                if(isset($param['output']) && !$this->checkValidFileName(basename($param['output']))){
                    $this->errorMsg->addMsg("in array index $key, ".$param['output']." does not contain a valid filename.");
                }

            }
        }

        return $this->errorMsg;
    }

    /**
     * Return if a path contain a valid filename.
     * @return bool
     */
    private function checkValidFileName(string $path){
            return preg_match('/(\.)()[a-zA-Z0-9]+$/', $path) > 0;
    }


    /**
     * Replace not allowed char in file/folder by windows
     * @param string $string
     * @param string $replaceBy
     * @return string
     */
    private function replaceNotAllowedCharWindows(string $string, string $replaceBy = '-'): string {
        $regexNotAllowCharWindows = '/\\|\\|\/|:|\*|\?|"|<|>|\|/m';
        return preg_replace($regexNotAllowCharWindows,$replaceBy,$string);
    }
}
