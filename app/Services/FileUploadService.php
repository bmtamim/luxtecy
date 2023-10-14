<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public static function uploadFile($file, $oldFilePath = null): string
    {
        $content  = $file->getContent();
        $hashName = time().$file->hashName();

        return self::saveFile($content, $hashName, $oldFilePath);
    }

    public static function deleteFile($thumbnail_url): void
    {
        //Get Disk
        $disk = Storage::disk('public');

        //Delete File if Thumbnail is not null
        if ($thumbnail_url) {
            $oldFilePath = str_replace(config('app.url').'/storage/', '', $thumbnail_url);

            $disk->delete($oldFilePath);
        }
    }


//    public static function uploadFromUrl($url, $oldFilePath = null): string
//    {
//        $file     = UploadedFile::
//        $content  = file_get_contents($url);
//        $hashName = time().$file->hashName();
//
//        return self::saveFile($content, $hashName, $oldFilePath);
//    }

    public static function saveFile($content, $hashName, $oldFilePath = null): string
    {
        //Generate Dynamic Path
        $dynamicPath = 'upload/'.date('Y').'/'.date('m').'/'.date('d');

        //Get Disk
        $disk = Storage::disk('public');

        //Create Directory if Not Exists
        if ( ! $disk->exists($dynamicPath)) {
            $disk->makeDirectory($dynamicPath);
        }

        //IF old file present then delete old file to free the disk
        if ($oldFilePath) {
            $disk->delete($oldFilePath);
        }

        //Generate File url/path
        $filePath = $dynamicPath.'/'.$hashName;

        //Put File
        $disk->put($filePath, $content);

        //Generate File Public Path And Return
        return $filePath;
    }
}
