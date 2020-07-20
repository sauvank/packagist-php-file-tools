<?php

namespace sauvank\ToolsMovieFiles;

class Files
{
    /**
     * Get all file by extensions.
     * @param string $path, path folder to scan.
     * @param array $exts, extension files available.
     * @return array
     */
    public function getFilesByExt(string $path, array $exts):array {

        // Generate regex from exts params.
        $regex = $this->createRegex($exts, '|');

        // List of folder exclude for search file.
        $excludeFolder = ['\$RECYCLE\.BIN', 'Trash-1000', 'found\.000'];
        $regExcludeFolder = $this->createRegex($excludeFolder, '|');

        $directory = new \RecursiveDirectoryIterator($path);
        $iterator = new \RecursiveIteratorIterator($directory);
        $files = [];

        foreach ($iterator as $info) {
            $pathInfo = pathinfo($info);
            $extension = $pathInfo['extension'];

            if(!isset($extension) || strlen($extension) <= 0){
                continue;
            }

            if(!preg_match_all($regex,$extension) || preg_match_all($regExcludeFolder,$pathInfo['dirname'])){
                continue;
            }
            $files[] = $pathInfo;
        }

        return $files;
    }

    /**
     * Generate basic regex form array
     * @param array $params
     * @param string $separator
     * @exemple createRegex(['mp4', 'mkv'], '|')
     * @output /mp4|mkv/
     * @return string
     */
    private function createRegex(array $params, string $separator):string {
        $regex = "/";
        foreach ($params as $value){
            $regex .= "$value|";
        }
        $regex = rtrim($regex,$separator);
        $regex.= "/";
        return $regex;
    }
}

$g = new Files();
echo $g->getFilesByExt('/app', ['mp4'] );