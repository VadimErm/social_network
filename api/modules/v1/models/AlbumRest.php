<?php


namespace api\modules\v1\models;

use common\helpers\Base64ToImageHelper;
use common\models\Album;
use Yii;

class AlbumRest extends Album
{
    public $imageFiles;

    public function rules()
    {
        parent::rules();

        return [
            ['imageFiles', 'safe']
        ];
    }

    public function save($runValidation = true, $attributes = null)
    {
        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }

        $path = \Yii::getAlias('@frontend').'/web';
        $images = $this->imageFiles;
        $imagesGQL = '';
        $imageNodes = '';

        if (!empty($images)) {
            $imagesGQL = ', ';
            $length = count($images);

            for ($i = 0; $i < $length; $i++) {
                $src = Base64ToImageHelper::SaveImage($images[$i], $path);
                $imagesGQL .= "(al)-[:has_image]->(i$i:Image{src:'$src'})";
                $imageNodes .= "i$i";

                if ($i != $length - 1) {
                    $imagesGQL .= ',';
                    $imageNodes .= ',';
                }
            }
        }
        $images = empty($imageNodes) ? '': ", [$imageNodes] as images";
        $userId = Yii::$app->user->getId();

        if ($attributes == null) {
            $attributes = $this->getAttributesStr($this->attributes());
        }

        return Album::find()
            ->match("(ac:Account{user_id: $userId})")
            ->create("(ac)-[:has_album]->(al:Album{{$attributes}})$imagesGQL")
            ->get("al, ID(al) as id$images")
            ->one();
    }

}