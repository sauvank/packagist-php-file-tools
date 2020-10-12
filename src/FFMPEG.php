<?php

namespace FileTools;

class FFMPEG
{
    public function __construct()
    {
        $ffmpeg = trim(shell_exec('which ffmpeg'));

        if(strlen($ffmpeg) === 0){
            throw new \Exception("install FFMPEG not found", 105);
        }
    }

    /**
     * Set metadata in a file.
     * @param string $filepath
     * @param array $metadata
     * @param bool $showOutputCmd
     * @return bool
     * @throws \Exception
     */
    public function setMetadata(string $filepath, array $metadata, bool $showOutputCmd = false):bool {

        if(!is_file($filepath)){
            throw new \Exception("$filepath is not a file.", 106);
        }

        $tmpdir = $this->createTmpDir(dirname($filepath));
        $tmpFile = $tmpdir . DIRECTORY_SEPARATOR . basename($filepath);

        $metadataOption = $this->buildMetadataOptCmd($metadata);

        $cmd = 'ffmpeg "-i" "'.$filepath.'" "-y" "-map" "0" "-c" "copy" "-max_muxing_queue_size" "9999" '.$metadataOption.' "'.$tmpFile.'"';

        if(!$showOutputCmd){
            $cmd .= " >/dev/null 2>&1 ";
        }

        exec($cmd, $output, $return);

        if ($return != 0) {
            unlink($tmpFile);
            rmdir($tmpdir);
            throw new \Exception("Echec to add metadata.", 107);
        }

        $oldFilename= 'old_'.basename($filepath);

        rename($filepath, dirname($filepath) .DIRECTORY_SEPARATOR.$oldFilename);
        rename($tmpFile, dirname($filepath) .DIRECTORY_SEPARATOR.basename($filepath));
        rmdir($tmpdir);
        unlink(dirname($filepath) .DIRECTORY_SEPARATOR.$oldFilename);

        return true;
    }

    /**
     * Get metadata from path file and title metadata
     * @param string $pathFile
     * @param string $metadata
     * @return bool|string, false if no metadata found  else return the metadata content.
     */
    public function readMetadata(string $pathFile, string $metadata){
        $cmd = 'ffmpeg  -i '.escapeshellarg($pathFile).' -f ffmetadata  2>&1 | grep '.$metadata;
        exec($cmd, $output, $return);

        if(!is_array($output) ||count($output) <= 0){
            return false;
        }

        $explode = explode(':', $output[0], 2);

        return count($explode) >= 1 ? trim($explode[1]) : false;
    }

    /**
     * Get all metadata contain file.
     * @param string $pathFile
     * @return array
     */
    public function getAllMetadata(string $pathFile):array {
        $cmd = 'ffmpeg  -i '.escapeshellarg($pathFile).' -f ffmetadata -r 1/1 pipe:1  -loglevel panic';

        exec($cmd, $output, $return);

        $explodeList = [];
        foreach ($output as $key => $value){
            $exp = explode('=', $value);
            if(count($exp) !== 2){
                continue;
            }
            $explodeList = array_merge($explodeList, [trim($exp[0]) => $exp[1]]);
        }

        return $explodeList;
    }

    /**
     * Return the cmd option for add metadata in file.
     * @param array $metadata
     * @return string
     */
    private function buildMetadataOptCmd(array $metadata):string {
        $metadataOption = '';
        foreach ($metadata as $key => $value){
            $value = html_entity_decode($value);
            $value = addslashes($value);
            $metadataOption .= " \"-metadata\" \"$key\"=\"$value\" ";
        }

        return $metadataOption;
    }

    /**
     * create the folder that will contain the temporary file.
     * @param string $basePath
     * @return string, the path of the tmp dir.
     */
    private function createTmpDir(string $basePath):string {
        $tmpPath = $basePath .'/.tmp';
        if(!is_dir($tmpPath)){
            mkdir($tmpPath);
        }

        return $tmpPath;
    }

}
