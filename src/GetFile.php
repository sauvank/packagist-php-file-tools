<?php
namespace FileTools;

class GetFile{

    /**
     * Get all files in directory with parameters for allow only files extension and baned folder.
     * @param string $folderPath
     * @param array $extsToGet
     * @param array $excludeFolder
     * @return array contain FileClass
     * @throws \Exception
     */

    public function byExtension(string $folderPath, array $extsToGet = [], array $excludeFolder = ['\$RECYCLE\.BIN', 'Trash-1000', 'found\.000']):array {

        if(!is_dir($folderPath)){
            throw new \Exception($folderPath . ' is not a directory', 110);
        }

        $directory = new \RecursiveDirectoryIterator($folderPath);
        $iterator = new \RecursiveIteratorIterator($directory);
        $files = [];

        foreach ($iterator as $info) {
            $pathInfo = pathInfo($info);

            $extension = $pathInfo['extension'];

            if(!$extension || strlen($extension) <= 0){
                continue;
            }

            if((!in_array($extension, $extsToGet) && count($extsToGet) > 0) || in_array($pathInfo['dirname'], $excludeFolder)){
                continue;
            }

            $files[] = new File($pathInfo);
        }

        return $files;

    }

    /**
     * Get file by folder and extension, return multidimentional array with key equal folder and value equal file
     * @param string $folderPath
     * @param array $extsToGet
     * @param array $excludeFolder
     * @return array
     * @throws \Exception
     */
    public function byFolderAndExtension(string $folderPath, array $extsToGet = [], array $excludeFolder = ['\$RECYCLE\.BIN', 'Trash-1000', 'found\.000']):array {
        $files = $this->byExtension( $folderPath, $extsToGet = [], $excludeFolder = ['\$RECYCLE\.BIN', 'Trash-1000', 'found\.000']);

        $folders= [];

        foreach ($files as $file){
            if(!isset($folders[$file->getDirname()])){
                $folders[$file->getDirname()] = [];
            }
            $folders[$file->getDirname()][] = $file;
        }

        return $folders;
    }
}
