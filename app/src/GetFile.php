<?php

namespace FileTools;

use League\CLImate\CLImate;

class GetFile
{
    private CLImate $climate;
    private $verbose;
    private Misc $misc;
    private LogCli $log;

    /**
     * GetFile constructor.
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

        $this->log->info('Base fodler to search : ', $path);
        $this->log->info('Get files by extension', implode(',',$exts));


        // Generate regex from exts params.
        $regex = $this->createRegex($exts, '|');

        $this->log->info('Regex available extension', $regex);

        // List of folder exclude for search file.
        $excludeFolder = ['\$RECYCLE\.BIN', 'Trash-1000', 'found\.000'];
        $regExcludeFolder = $this->createRegex($excludeFolder, '|');


        $this->log->info('regex exclude folder : ', $regExcludeFolder);


        $directory = new \RecursiveDirectoryIterator($path);
        $iterator = new \RecursiveIteratorIterator($directory);
        $files = [];


        foreach ($iterator as $info) {
            $pathInfo = pathinfo($info);

            $pathInfo['full_path'] = $pathInfo['dirname'] . DIRECTORY_SEPARATOR . $pathInfo['basename'];
            $mime = mime_content_type($pathInfo['full_path']);
            $extension = $this->misc->mime2ext($mime);

            // extension is not the mime type.
            if($mime !== 'directory' && $extension !== $pathInfo['extension']){
                $this->log->warning([
                    'File : ' . $pathInfo['full_path'],
                    'mime type is not equal to extension file.',
                    'mime type file : '. $mime . ' | extension file: ' .$pathInfo['extension'],
                    'Skipping file'
                ]);
                continue;
            }

            if(!$extension || strlen($extension) <= 0){
                continue;
            }

            if(!preg_match_all($regex,$extension) || preg_match_all($regExcludeFolder,$pathInfo['dirname'])){
                continue;
            }

            $pathInfo['size'] = filesize($pathInfo['full_path']);
            $files[] = $pathInfo;
        }

        $this->log->info('Total file(s) found : ', count($files));

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
            $regex .= "$value".$separator;
        }
        $regex = rtrim($regex,$separator);
        $regex.= "/";

        return $regex;
    }
}
