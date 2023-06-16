<?php

namespace Tests\Helpers;

use Illuminate\Http\UploadedFile;

class UploadFileHelper
{
    public static function makeFakeImage($filename)
    {
        $file = UploadedFile::fake()->image($filename);
        return $file;
    }
}

