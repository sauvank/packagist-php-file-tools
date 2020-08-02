<?php
namespace FileTools;


class MoveFiles
{

    /**
     * Move a file in the new path
     * @param $src , the full path of origin file
     * @param $output , the full path of output file
     * @param bool $createOutputPath, if folders output file not exist create this.
     * @return array
     */
    public function move($src, $output, bool $createOutputPath = true): array {

        if(!is_file($src)){
            return ['error' => true, 'msg' => 'File ' . $src . ' not exist !'];
        }

        $SliceOutput = $this->sliceNameFileFromPath($output);

        if(!$SliceOutput['file_name']){
            return ['error' => true, 'msg' => 'Output path contain any file name !'];
        }

        if($createOutputPath && !is_dir($SliceOutput['folder_path'])){
            $isCreate = mkdir($SliceOutput['folder_path'], 0700, true);

            if(!$isCreate){
                return ['error' => true, 'msg' => 'Folder output not created !'];
            }
        }

        $output = $this->replaceNotAllowedCharWindows($output);
        $isMove =  rename($src, $output);

        $msg = $isMove ? 'File is move from ' . $src . ' to ' . $output : 'File is NOT move !';
        return ['error' => !$isMove, 'msg' => $msg, 'new_full_path' => $output];
    }

    /**
     * Replace not allowed char in file/folder by windows
     * @param string $string
     * @param string $replaceBy
     * @return string
     */
    private function replaceNotAllowedCharWindows(string $string, string $replaceBy = ' - '): string {
        $regexNotAllowCharWindows = '/\\|\\|\/|:|\*|\?|"|<|>|\|/m';
        return preg_replace($regexNotAllowCharWindows,$replaceBy,$string);
    }

    /**
     * Return a array contain the path and the file name from a path.
     * @param string $path
     * @return array
     */
    private function sliceNameFileFromPath(string $path){
        preg_match('/[\w-]+\.[\w\d]+/', $path, $callback);
        return [
            'folder_path' => str_replace($callback, '', $path),
            'file_name' => isset($callback[0]) ? $callback[0] : false
        ];
    }
}
