<?php

    function Generate_GUID_V4_Business() 
    {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40); // version 4
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80); // bits 6-7
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }


    /**
     * Upload image to specific folder inside /uploads/
     *
     * @param string $InputName  Name of input that used to upload img (input tag in html)
     * @param string $FolderName Name of folder inside /uploads/
     * @param string $ErrorMsg   Returned error message
     * @param int    $ErrorCode  Returned error code
     *
     * @return string|false  Returns saved filename or false on error
     */
    function UploadImgToFolder_Business(string $InputName, string $FolderName,  string &$ErrorMsg = "", int &$ErrorCode = 0)
    {
        $FolderName = preg_replace("/[^a-zA-Z0-9_-]/", "", $FolderName);

        if (empty($_FILES[$InputName]['name'])) 
        {
            $ErrorCode = 1;
            $ErrorMsg  = "No file uploaded.";
            return false;
        }

        $File = $_FILES[$InputName];

        // Basic upload error
        if ($File['error'] !== UPLOAD_ERR_OK) 
        {
            $ErrorCode = 2;
            $ErrorMsg  = "Upload error code: " . $File['error'];
            return false;
        }

        // Limit: 2MB
        if ($File['size'] > 2 * 1024 * 1024) 
        {
            $ErrorCode = 3;
            $ErrorMsg  = "Image size must be < 2MB.";
            return false;
        }

        // Clean name
        $OriginalName = strtolower($File['name']);
        $OriginalName = strip_tags($OriginalName);
        $OriginalName = str_replace(["..", "/", "\\", "\0"], "", $OriginalName);
        $OriginalName = preg_replace("/[^a-zA-Z0-9._-]/", "", $OriginalName);
        $FileExt      = strtolower(pathinfo($OriginalName, PATHINFO_EXTENSION));

        // Allowed extensions
        $AllowedExts = ['jpg','jpeg','png','webp'];
        if (!in_array($FileExt, $AllowedExts)) 
        {
            $ErrorCode = 4;
            $ErrorMsg  = "Invalid image extension.";
            return false;
        }

        // Real image?
        $ImgInfo = @getimagesize($File['tmp_name']);
        if (!$ImgInfo) 
        {
            $ErrorCode = 5;
            $ErrorMsg  = "Not a real image.";
            return false;
        }

        $AllowedMime = ['image/jpeg','image/png','image/webp'];
        if (!in_array($ImgInfo['mime'], $AllowedMime)) 
        {
            $ErrorCode = 6;
            $ErrorMsg  = "Invalid image MIME.";
            return false;
        }

        // Extra MIME check
        $RealMime = mime_content_type($File['tmp_name']);
        if (!in_array($RealMime, $AllowedMime)) 
        {
            $ErrorCode = 7;
            $ErrorMsg  = "MIME mismatch.";
            return false;
        }

        // Generate final filename
        $Img_GUID_Name = Generate_GUID_V4_Business() . "." . $FileExt;

        // Build final folder path
        $UploadDir = __DIR__ . "/../uploads/" . $FolderName . "/";

        // Create folder if missing
        if (!is_dir($UploadDir)) {
            mkdir($UploadDir, 0755, true);
        }

        // Save file
        if (move_uploaded_file($File['tmp_name'], $UploadDir . $Img_GUID_Name))
        {
            return $Img_GUID_Name; // return final filename
        }

        $ErrorCode = 8;
        $ErrorMsg  = "Failed to move uploaded image.";
        return false;
    }

    /**
     * move image to specific folder inside /uploads/
     *
     * @param string $ImageName  Name of image in source folder
     * @param string $SourceFolder Name of folder inside /uploads/ that contain the img
     * @param string $DestFolder Name of folder inside /uploads/ to the img to it
     *
     * @return bool  True if moved successfully, false on error
     */
    function MoveImgToAnotherFolder_Business(string $ImageName, string $SourceFolder, string $DestFolder)
    {
        $SourceFolder = preg_replace("/[^a-zA-Z0-9_-]/", "", $SourceFolder);
        $DestFolder   = preg_replace("/[^a-zA-Z0-9_-]/", "", $DestFolder);

        $Source = __DIR__ . "/../uploads/$SourceFolder/" . $ImageName;
        $Dest   = __DIR__ . "/../uploads/$DestFolder/" . $ImageName;

        if (!file_exists($Source)) 
        {
            return false;
        }

        // create new folder if missing
        if (!is_dir(dirname($Dest))) 
        {
            mkdir(dirname($Dest), 0755, true);
        }

        if (rename($Source, $Dest)) 
        {
            return true;
        }

        return false;
    }

    /**
     * Delete image from a specific folder inside /uploads/
     *
     * @param string $ImageName  Name of the image file
     * @param string $FolderName Name of the folder inside /uploads/ containing the image
     *
     * @return bool  True if deleted successfully, false if file not found or error
     */
    function DeleteImageFromFolder_Business(string $ImageName, string $FolderName)
    {
        // Sanitize folder name
        $FolderName = preg_replace("/[^a-zA-Z0-9_-]/", "", $FolderName);

        // Build full path
        $FilePath = __DIR__ . "/../uploads/$FolderName/" . $ImageName;

        // Check if file exists
        if (!file_exists($FilePath)) 
        {
            return false;
        }

        // Attempt to delete
        if (unlink($FilePath)) 
        {
            return true;
        }

        return false; // failed to delete
    }







?>