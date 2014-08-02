<?php

/**
 * Sirius V2
 * 
 * @copyright Copyright (c) 2014 Media Meeting (http://www.mediameeting.fr)
 */

namespace Admin\Service;

use FFMpeg\FFMpeg;

/**
 * Common functionality service for Admin module
 *
 */
class AdminService
{
    /**
     *
     * @var \FFMpeg\FFMpeg ffmpeg
     */
    protected $ffmpeg;
    
    /**
     * Constructor
     * 
     * @param \FFMpeg\FFMpeg $ffmpeg
     */
    public function __construct(FFMPeg $ffmpeg)
    {
        $this->ffmpeg = $ffmpeg;
    }
    
    /* DIRECTORY TREATMENT */

    /**
     * Generate file storage path to record in database
     * 
     * @param string $subDirectory
     * @param int $editionID
     * @param string $locale
     * @param int $chapterID
     * 
     * @return string the path of the file for database recording
     */
    public function generateFileStoragePath($subDirectory, $editionID, $locale, $chapterID)
    {
        // Get current date to build storage path
        $currentDate = new \DateTime('now');
        $currentYear = $currentDate->format('Y');

        return "/{$subDirectory}/{$currentYear}/edition-{$editionID}/{$locale}/chapter-{$chapterID}/";
    }

    /**
     * Create directory if it doesn't exist yet
     * 
     * @param string $path directory or file path
     * 
     * @throws \Exception if error occurs when creating the directory
     */
    public function createDirectoryIfNotExists($path)
    {
        $directoryPath = substr($path, 0, strrpos($path, '/'));

        if (! is_dir($directoryPath)) {
            if (! mkdir($directoryPath, 0775, true)) {
                throw new \Exception("Could not create directory $directoryPath !");
            }
        }
    }

    /**
     * Delete a directory if it's empty
     * 
     * @param string $path file or directory path
     * @throws \Exception if error occurs when deleting directory
     */
    public function removeDirectoryIfEmpty($path)
    {
        // Correctly format directory path
        $directoryPath = rtrim(substr($path, 0, strrpos($path, '/')), '/') . DIRECTORY_SEPARATOR;

        $directoryToStop = array('draft', 'editorial'); // Directory from where to stop delete

        if (! in_array(basename($directoryPath), $directoryToStop)) {
            $directoryScan = array_diff(scandir($directoryPath), array('.', '..'));

            // Remove directory if empty
            if (! $directoryScan) {
                if (!rmdir($directoryPath)) {
                    throw new \Exception("Could not delete $directoryPath");
                }

                // Check in parent directory needs to be deleted
                $this->removeDirectoryIfEmpty(substr($directoryPath, 0, strrpos($directoryPath, '/')));
            }
        }
    }

    /* FILE TREATMENT */
    
    /**
     * Get MIME TYPE for specified file filename
     * 
     * @param string $filename
     * 
     * @return string
     */
    public function getFileMimeType($filename)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        
        return finfo_file($finfo, $filename);
    }
    
    /**
     * Format filename for uploaded files
     * 
     * @param array $uploadedFile $_FILES element
     * 
     * @return string the generated file name
     */
    public function formatUploadedFileName(array $uploadedFile, $title)
    {
        if (strstr($this->getFileMimeType($uploadedFile['tmp_name']), '/', true) == 'video')
        {
    	    $extension = 'mp4';
        }
        else
        {
            $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
        }
      
        return $this->getStringSlug($title) . '.' . $extension;
    }

    /**
     * Set file name for chapter update
     * 
     * @param array $uploadedFile $_FILES element
     * @param string $currentName current file name
     * 
     * @return string file name to record for chapter update
     */
    public function getUpdatedMediaFileName(array $uploadedFile, $currentName, $title)
    {
        // Format a new name if file is replaced
        if ($uploadedFile['name'] && $uploadedFile['error'] == UPLOAD_ERR_OK) {
            return $this->formatUploadedFileName($uploadedFile, $title);
        }
        // Keep same name if same file
        else {
            return basename($currentName);
        }
    }

    /**
     * Delete a file
     * 
     * @param string $path path of the file to delete
     * 
     * @throws \Exception if error occurs when deleting file
     * 
     * @return boolean true on success
     */
    public function removeFile($path)
    {
        if (! unlink($path)) {
            throw new \Exception("Could not delete $path");
        }

        /* Also delete directory if empty */
        $this->removeDirectoryIfEmpty($path);

        return true;
    }
    
    public function transcodeVideoToMp4($from, $to)
    {
        
    }

    /**
     * Store uploadedFile to storagePath
     * 
     * @param array $uploadedFile $_FILES element
     * @param string $storagePath path to store the uploaded file
     * 
     * @return boolean true on success
     */
    public function storeFile(array $uploadedFile, $storagePath)
    {
        // Create directory if needed
        $this->createDirectoryIfNotExists($storagePath);

        // Store file
        if ($uploadedFile['error'] == UPLOAD_ERR_OK) {
            
            // If file need to be encoded add prefix TO_ENCODE_ to its name
            $suffix = (strstr($this->getFileMimeType($uploadedFile['tmp_name']), '/', true) == 'video' && $this->getFileMimeType($uploadedFile['tmp_name']) != 'video/mp4') ? '.TO_ENCODE' : '';
            if (!move_uploaded_file($uploadedFile['tmp_name'], $storagePath . $suffix)) {
                throw new \Exception("Could not store fil $storagePath}");
            }        

            // Transcode video to MP4 if needed
            if ($suffix) {
                $this->transcodeVideoToMp4($storagePath . $suffix, $storagePath);
            }
 
            return true;
        }

        throw new \Exception("Upload issue with {$uploadedFile['tmp_name']}");
    }

    /**
     * Update $uploadedFile storage
     * 
     * @param array $uploadedFile $_FILES element
     * @param string $basePath root directory to store file
     * @param string $currentPath current path of the file
     * @param string $storagePath path to store the file from the base path
     * 
     * @return boolean true on success
     */
    public function editFile(array $uploadedFile, $basePath, $currentPath, $storagePath)
    {
        // Nothing to do if currentPath and storagePath are the same
        if ($storagePath == $currentPath) {
            return true;
        } else {
            // Set complete paths
            $completeCurrentPath = $basePath . $currentPath;
            $completeStoragePath = $basePath . $storagePath;

            // Move from draft/ to editorial/ or the other if file is not changed
            if ($uploadedFile['error'] == UPLOAD_ERR_NO_FILE) {
                // Create directory if needed
                $this->createDirectoryIfNotExists($completeStoragePath);

                // Copy file to new path
                if (! copy($completeCurrentPath, $completeStoragePath)) {
                    throw new \Exception("Could not copy $completeCurrentPath to $completeStoragePath");
                }
            }
            // File is changed
            else {
                // Store new file
                $this->storeFile($uploadedFile, $completeStoragePath);
            }

            // Remove old file
            $completed = $this->removeFile($completeCurrentPath);

            return $completed;
        }
    }
    
    /**
     * Store draft files of an online version
     * 
     * @param array $uploadedFile $_FILES element
     * @param string $basePath root directory to store file
     * @param string $currentPath current path of the file
     * @param string $storagePath path to store the file from the base path
     * 
     * @throws \Exception if error occurs when copying file
     * 
     * @return boolean true on success
     */
    public function manageDraftFile(array $uploadedFile, $basePath, $currentPath, $storagePath)
    {
        // Set complete paths
        $completeCurrentPath = $basePath . $currentPath;
        $completeStoragePath = $basePath . $storagePath;

        // Copy online file if none uploaded
        if ($uploadedFile['error'] == UPLOAD_ERR_NO_FILE) {
            // Create directory if needed
            $this->createDirectoryIfNotExists($completeStoragePath);

            // Copy file to new path
            if (! copy($completeCurrentPath, $completeStoragePath)) {
                throw new \Exception("Could not copy $completeCurrentPath to $completeStoragePath");
            }
        }
        // File is changed
        else {
            // Store new file
            $this->storeFile($uploadedFile, $completeStoragePath);
        }

        return true;
    }
    
    /* STRING TREATMENT */
    
    /**
     * Get slug from specified string
     * 
     * @param string $string
     * 
     * @return string
     */
    public function getStringSlug($string) 
    {
    	$stripSpecialChars = str_replace(
			array('à', 'á', 'â', 'ã', 'ä', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', '&', '(', ')', '{', '}', '[', ']', ' '), 
	        array('a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', '_', '-', '-', '-', '-', '-', '-', '_'), 
	        trim($string));
    
    	$stripQuotes = $this->stripQuotes($stripSpecialChars);
    
    	$lowerCase = strtolower($stripQuotes);
    
    	$finalString = preg_replace("/[^A-Za-z0-9-._]/", "_", $lowerCase);
    
    	return $finalString;
    }
    
    /**
     * Remove quotes
     * 
     * @param string $stringToStrip
     * 
     * @return string
     */
    public function stripQuotes($stringToStrip) 
    {
    	$stripQuotes = str_replace("'", "-", trim($stringToStrip));
    
    	return $stripQuotes;
    }

}