<?php


namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;


class UploadImage extends  Model
{
    public $imageFile;

    CONST UPLOAD_DIR  = 'uploads/';

    public $imagePath;

    public function rules()
    {
        return [
            ['imageFile', 'safe']
        ];
    }
    /*public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg, jpeg'],
        ];
    }*/

    public function upload()
    {
        if ($this->validate()) {

            $this->imagePath = self::UPLOAD_DIR . $this->imageFile->baseName . '.' . $this->imageFile->extension;

            $this->imageFile->saveAs($this->imagePath);

            return true;

        } else {

            return false;

        }
    }

    public function uploadMultiple()
    {
        if ($this->validate()) {
            $savedFiles = [];

            foreach ($this->imageFile as $file) {
                $this->imagePath = self::UPLOAD_DIR . md5($file->baseName) . '_' . time() . '.' . $file->extension;
                $savedFiles[] = $this->imagePath;

                $file->saveAs($this->imagePath);
            }

            return $savedFiles;

        } else {

            return false;

        }
    }

}