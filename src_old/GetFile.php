<?php

namespace FileTools;

use League\CLImate\CLImate;
use SplFileInfo;

class GetFile
{
    private CLImate $climate;
    private $verbose;
    private Misc $misc;
    private LogCli $log;

    /**
     * GetFileTest constructor.
     * @param bool $verbose, set true for get log
     */
    public function __construct(bool $verbose = false)
    {
        $this->climate = new CLImate();
        $this->verbose = $verbose;
        $this->misc = new Misc();
        $this->log = new LogCli();
    }

    /**
     * Get all file by extensions.
     * @param string $path, path folder to scan.
     * @param array $exts, extension files available.
     * @return array
     */
    public function getFilesByExt(string $path, array $exts):array {
        $this->verbose ? $this->log->info('Base folder to search : ', $path): null;
        $this->verbose ? $this->log->info('Get files by extension', implode(',',$exts)): null;

        // Generate regex from exts params.
        $regexAllowExtension = $this->createRegex($exts, '|');

        $this->verbose ? $this->log->info('Regex available extension', $regexAllowExtension) : null;

        // List of folder exclude for search file.
        $excludeFolder = ['\$RECYCLE\.BIN', 'Trash-1000', 'found\.000'];
        $regexDisallowFolder = $this->createRegex($excludeFolder, '|');

        $this->verbose ? $this->log->info('regex exclude folder : ', $regexDisallowFolder) : null;

        $files = $this->getFilesInDirectory($path, $regexAllowExtension, $regexDisallowFolder);

        $this->verbose ? $this->log->info('Total file(s) found : ', count($files)) : null;

        return $files;
    }

    /**
     * Get all files in directory with parameters for allow only files extension and baned folder.
     * @param string $path
     * @param $regexAllowExtension, exemple : /mkv|avi/
     * @param $regexDisallowFolder, exemple : /folder1|folder2/
     * @return array
     */
    public function getFilesInDirectory(string $path, $regexAllowExtension, $regexDisallowFolder):array {

        if(!is_dir($path)){
            return ['error' => true, 'msg' => $path . ' is not a directory'];
        }

        $directory = new \RecursiveDirectoryIterator($path);
        $iterator = new \RecursiveIteratorIterator($directory);
        $files = [];

        foreach ($iterator as $info) {
            $pathInfo = $this->fileInfo($info);

            if(isset($pathInfo['error']) && $pathInfo['error']){
                continue;
            }

            $mime = mime_content_type($pathInfo['full_path']);
            $extension = $this->misc->mime2ext($mime);

            // extension is not the mime type.
            if($mime !== 'directory' && $extension !== $pathInfo['extension']){
                $this->verbose ? $this->log->warning([
                    'File : ' . $pathInfo['full_path'],
                    'mime type is not equal to extension file.',
                    'mime type file : '. $mime . ' | extension file: ' .$pathInfo['extension'],
                    'Skipping file'
                ]) : null;
                continue;
            }

            if(!$extension || strlen($extension) <= 0){
                continue;
            }

            if(!preg_match_all($regexAllowExtension,$extension) || preg_match_all($regexDisallowFolder,$pathInfo['dirname'])){
                continue;
            }

            $files[] = $pathInfo;
        }

        return $files;
    }

    /**
     * Return data files ( pathinfo, size, full_path ....)
     * @param $info
     * @return string|string[]
     */
    public function fileInfo(SplFileInfo $info): array {
        $pathInfo = pathinfo($info);
        $pathInfo['full_path'] = $pathInfo['dirname'] . DIRECTORY_SEPARATOR . $pathInfo['basename'];

        if(!is_file($pathInfo['full_path'])){
            return ['error' => true, 'file : ' . $pathInfo['full_path'] . ' not exist.'];
        }

        $pathInfo['size'] = filesize($pathInfo['full_path']);
        return $pathInfo;
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
            $regex .= "$value".$separator;
        }
        $regex = rtrim($regex,$separator);
        $regex.= "/";

        return $regex;
    }
}
