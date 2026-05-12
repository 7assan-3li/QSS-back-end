<?php

namespace App\Services;

use Kreait\Firebase\Contract\Storage;
use Illuminate\Support\Str;

class FirebaseStorageService
{
    protected $storage;
    protected $bucket;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
        $this->bucket = $storage->getBucket();
    }

    /**
     * Upload a file to Firebase Storage and return its public URL.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $path Folder path in Firebase
     * @return string
     */
    public function upload($file, $path = 'uploads')
    {
        $fileName = $path . '/' . Str::random(20) . '.' . $file->getClientOriginalExtension();
        
        $object = $this->bucket->upload(
            fopen($file->getRealPath(), 'r'),
            [
                'name' => $fileName,
                'predefinedAcl' => 'publicRead'
            ]
        );

        // Return the public URL
        return "https://storage.googleapis.com/{$this->bucket->name()}/{$fileName}";
    }

    /**
     * Delete a file from Firebase Storage.
     *
     * @param string $url Full public URL of the file
     * @return bool
     */
    public function delete($url)
    {
        try {
            $path = parse_url($url, PHP_URL_PATH);
            $segments = explode('/', $path);
            
            // The actual file path starts after the bucket name
            $fileName = implode('/', array_slice($segments, 2));
            
            $object = $this->bucket->object($fileName);
            if ($object->exists()) {
                $object->delete();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
