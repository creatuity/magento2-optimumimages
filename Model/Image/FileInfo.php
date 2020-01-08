<?php
declare(strict_types=1);

namespace Creatuity\OptimumImages\Model\Image;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\ReadInterface;
use Magento\Framework\Filesystem\Directory\WriteInterface;

class FileInfo
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Mime
     */
    private $mime;

    /**
     * @var WriteInterface
     */
    private $mediaDirectory;

    /**
     * @var ReadInterface
     */
    private $baseDirectory;

    /**
     * @param Filesystem $filesystem
     * @param Mime $mime
     */
    public function __construct(
        Filesystem $filesystem,
        Mime $mime
    ) {
        $this->filesystem = $filesystem;
        $this->mime = $mime;
    }

    /**
     * Check if the file exists
     *
     * @param string $fileName
     * @return bool
     * @throws FileSystemException
     */
    public function isExist($fileName)
    {
        $filePath = $this->getFilePath($fileName);

        $result = $this->getMediaDirectory()->isExist($filePath);
        return $result;
    }

    /**
     * Retrieve MIME type of requested file
     *
     * @param string $fileName
     * @return string
     * @throws FileSystemException
     */
    public function getMimeType($fileName)
    {
        $filePath = $this->getFilePath($fileName);
        $absoluteFilePath = $this->getMediaDirectory()->getAbsolutePath($filePath);

        $result = $this->mime->getMimeType($absoluteFilePath);
        return $result;
    }

    /**
     * Checks for whether $fileName string begins with media directory path
     *
     * @param string $fileName
     * @return bool
     * @throws FileSystemException
     */
    public function isBeginsWithMediaDirectoryPath($fileName)
    {
        $filePath = ltrim($fileName, '/');
        $mediaDirectoryRelativeSubpath = $this->getMediaDirectoryPathRelativeToBaseDirectoryPath();

        return strpos($filePath, $mediaDirectoryRelativeSubpath) === 0;
    }

    /**
     * Get file statistics data
     *
     * @param string $fileName
     * @return array
     * @throws FileSystemException
     */
    public function getStat($fileName)
    {
        $filePath = $this->getFilePath($fileName);

        $result = $this->getMediaDirectory()->stat($filePath);
        return $result;
    }

    /**
     * Construct and return file subpath based on filename relative to media directory
     *
     * @param string $fileName
     * @return string
     * @throws FileSystemException
     */
    private function getFilePath($fileName)
    {
        $filePath = ltrim($fileName, '/');

        $mediaDirectoryRelativeSubpath = $this->getMediaDirectoryPathRelativeToBaseDirectoryPath();

        if ($this->isBeginsWithMediaDirectoryPath($fileName)) {
            $filePath = substr($filePath, strlen($mediaDirectoryRelativeSubpath));
        } else {
            $filePath = Config::ENTITY_MEDIA_PATH . '/' . $filePath;
        }

        return $filePath;
    }

    /**
     * Get media directory subpath relative to base directory path
     *
     * @return string
     * @throws FileSystemException
     */
    private function getMediaDirectoryPathRelativeToBaseDirectoryPath()
    {
        $baseDirectoryPath = $this->getBaseDirectory()->getAbsolutePath();
        $mediaDirectoryPath = $this->getMediaDirectory()->getAbsolutePath();

        $mediaDirectoryRelativeSubpath = substr($mediaDirectoryPath, strlen($baseDirectoryPath));

        return $mediaDirectoryRelativeSubpath;
    }

    /**
     * Get Base Directory read instance
     *
     * @return ReadInterface
     */
    private function getBaseDirectory()
    {
        if (!isset($this->baseDirectory)) {
            $this->baseDirectory = $this->filesystem->getDirectoryRead(DirectoryList::ROOT);
        }

        return $this->baseDirectory;
    }

    /**
     * Get WriteInterface instance
     *
     * @return WriteInterface
     * @throws FileSystemException
     */
    private function getMediaDirectory()
    {
        if ($this->mediaDirectory === null) {
            $this->mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        }
        return $this->mediaDirectory;
    }
}