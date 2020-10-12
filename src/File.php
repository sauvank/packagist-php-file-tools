<?php
namespace FileTools;

class File
{
    protected ?string $dirname = null;
    protected ?string $basename = null;
    protected ?string $extension = null;
    protected ?string $filename = null;
    protected ?string $fullPath = null;
    protected ?string $mimeType = null;
    protected ?int $fileSize = null;
    protected ?string $lastPath = null;

    public function __construct(array $pathInfo = [])
    {
        if(count($pathInfo) === 0){
            return;
        }

        $this->dirname = $pathInfo['dirname'];
        $this->basename = $pathInfo['basename'];
        $this->extension = $pathInfo['extension'];
        $this->filename = $pathInfo['filename'];

    }

    /**
     * @return mixed
     */
    public function getDirname():?string
    {
        return $this->dirname;
    }

    /**
     * @param mixed $dirname
     */
    public function setDirname($dirname): void
    {
        $this->dirname = $dirname;
    }

    /**
     * @return mixed
     */
    public function getBasename():?string
    {
        return $this->basename;
    }

    /**
     * @param mixed $basename
     */
    public function setBasename($basename): void
    {
        $this->basename = $basename;
    }

    /**
     * @return mixed
     */
    public function getExtension():?string
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return mixed
     */
    public function getFilename():?string
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getFullPath():?string
    {
        return $this->dirname . DIRECTORY_SEPARATOR . $this->filename .'.'.$this->extension;
    }

    /**
     * @return mixed
     */
    public function getMimeType():?string
    {
        return mime_content_type($this->fullPath);
    }

    /**
     * @return null
     */
    public function getFileSize():?int
    {
        return filesize($this->fullPath);
    }

    /**
     * @return null
     */
    public function getLastPath():?string
    {
        return $this->lastPath;
    }

    /**
     * @param null $lastPath
     */
    public function setLastPath($lastPath): void
    {
        $this->lastPath = $lastPath;
    }



}
