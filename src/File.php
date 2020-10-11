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
    /**
     * @return mixed
     */
    public function getDirname()
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
    public function getBasename()
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
    public function getExtension()
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
    public function getFilename()
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
    public function getFullPath()
    {
        return $this->dirname . DIRECTORY_SEPARATOR . $this->filename .'.'.$this->extension;
    }

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param mixed $mimeType
     */
    public function setMimeType($mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return null
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * @param null $fileSize
     */
    public function setFileSize($fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    /**
     * @return null
     */
    public function getLastPath()
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
