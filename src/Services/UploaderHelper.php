<?php

namespace App\Services;

use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper{

    private $uploads_path;

    public function __construct(string $uploads_path)
    {

        $this->uploads_path = $uploads_path;
    }

    public function uploadImage(UploadedFile $uploadedFile):string
    {
        $destination = $this->uploads_path.'/profile_picture';
        $fileName = $uploadedFile->getClientOriginalName();
        $originalFileName = pathinfo($fileName,PATHINFO_FILENAME);
        $newFileName = Urlizer::urlize($originalFileName).'-'.uniqid().'.'.$uploadedFile->guessExtension();
        $uploadedFile->move($destination,$newFileName);

        return $newFileName;
    }
}