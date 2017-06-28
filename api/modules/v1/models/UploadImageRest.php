<?php


namespace api\modules\v1\models;

use common\helpers\Base64ToImageHelper;
use common\models\UploadImage;

class UploadImageRest extends UploadImage
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

    public function __construct($imageFile,  array $config = [])
    {
        parent::__construct($config);

        $this->imageFile = $imageFile;
    }

    public function upload()
    {

        if ($this->validate()) {
            $path = \Yii::getAlias('@frontend').'/web';
            $this->imagePath = Base64ToImageHelper::SaveImage($this->imageFile, $path);

            return $this->imagePath;

        } else {

            return false;

        }
    }

    public function uploadMultiple()
    {
        if ($this->validate()) {
            $savedFiles = [];

            foreach ($this->imageFile as $file) {
                $path = \Yii::getAlias('@frontend').'/web';
                $this->imagePath = Base64ToImageHelper::SaveImage($file, $path);
                $savedFiles[] = $this->imagePath;

            }

            return $savedFiles;

        } else {

            return false;

        }
    }

}