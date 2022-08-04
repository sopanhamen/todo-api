<?php

namespace App\Modules\FileUpload;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FileUploadService
{
    const IMAGE_DIR = 'images';
    const THUMBNAIL_DIR = 'images/thumbnails';
    const TEMP_DIR = 'tmp';

    /**
     * Uploader Disk
     *
     * @return Illuminate\Contracts\Filesystem\Filesystem|Illuminate\Support\Facades\Storage
     */
    public function storage(?string $disk = null): FileSystem|Storage
    {
        return Storage::disk($disk);
    }

    /**
     * Temporary file path
     *
     * @param string|null $directory
     * @return string Target upload path
     */
    public function tempPath(?string $directory =  null): string
    {
        $path = self::TEMP_DIR;
        if ($directory) {
            return $path . '/' . $directory;
        }

        return $path;
    }

    /**
     * Real file path
     *
     * @return string Target upload path
     */
    public function realPath(?string $directory = null): string
    {
        return $directory ?? '';
    }

    /**
     * Upload single file to temp folder
     *
     * @param Illuminate\Http\UploadedFile|Illuminate\Http\File $file
     * @param string|null $directory
     * @return string Uploaded path
     */
    public function uploadTemporaryFile(File|UploadedFile $file, ?string $directory = null): array
    {
        $tmpPath = $this->tempPath($directory);
        $uploadedPath = $this->storage()->putFile($tmpPath, $file);

        if (!$uploadedPath) {
            abort(500, 'Could not upload file.');
        }

        $fileName = $file->getClientOriginalName();

        return [
            'path' => $uploadedPath,
            'url' => $this->url($uploadedPath),
            'name' => $file->getClientOriginalName(),
            'file_type' => pathinfo($fileName, PATHINFO_EXTENSION)
        ];
    }

    /**
     * Upload Multiple files to temp folder
     *
     * @param array $files
     * @param string|null $directory
     * @return string Uploaded path
     */
    public function uploadTemporaryFiles(array $files, ?string $directory = null): array
    {
        $result = [];
        foreach ($files as $file) {
            $result[] = $this->uploadTemporaryFile($file, $directory);
        }

        return $result;
    }

    /**
     * @param string $tempPath
     * @param null|string $directory
     */
    public function createImage(string $fromPath, string $directory = '/', string $name, array $size = [1950, 1275]): ?string
    {
        [$width, $height] = $size;

        $original = $this->storage()->get($fromPath);
        $image = Image::make($original);
        $image->fit($width, $height);

        $fileName = $name . '_' . $width . 'x' . $height . '.jpg';
        $path = $directory . date('Y-m-d') . '/' . $fileName;

        $this->storage()->put($path, (string) $image->encode('jpg', 90));

        return $path;
    }

    /**
     * @param string $tempPath
     * @param null|string $directory
     */
    public function moveToRealPath(string $tempPath, ?string $directory = null): ?string
    {
        $realPath = Str::replace($this->tempPath() . '/', $this->realPath($directory), $tempPath);
        $this->storage()->move($tempPath,  $realPath);

        return $realPath;
    }

    /**
     * @param array $tempPath
     * @param null|string $directory
     */
    public function moveFilesToRealPath(array $tempPaths, ?string $directory = null)
    {
        $paths = [];
        foreach ($tempPaths as $tempPath) {
            $paths[] = $this->moveToRealPath($tempPath, $directory);
        }

        return $paths;
    }

    /**
     * @param string $originalPath,
     * @param int $width in pixel
     * @param int $height in pixel
     */
    public function createThumbnailFrom(string $originalPath, int $width = null, int $height = null)
    {
        $original = $this->storage()->get($originalPath);
        $image = Image::make($original)
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });


        $thumbnailPath = Str::replace(self::IMAGE_DIR, self::THUMBNAIL_DIR, $originalPath);
        $this->storage()->put($thumbnailPath, (string) $image->encode('jpg', 90));

        return $thumbnailPath;
    }

    /**
     * string $path
     */
    public function delete(string $path,)
    {
        return $this->storage()->delete($path);
    }

    /**
     * Response file url from path
     *
     * @param string|null $filePath
     * @param string|null $defaultPath
     * @param string|null $disk
     * @return full url of the file
     */
    public function url(?string $filePath, ?string $defaultPath = null, ?string $disk = null): ?string
    {
        if (!$filePath) {
            return $defaultPath;
        }

        return $this->storage($disk)->url($filePath);
    }
}
