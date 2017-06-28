<?php

namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class Album extends ActiveRecord
{
    public $id;
    public $title;
    public $hidden = false;
    public $images = [];

    public $photoCount;


    public function rules()
    {
        return [
            ['id', 'safe'],
            ['title', 'string', 'min' => 1],
            ['hidden', 'boolean'],
            ['images', 'safe']
        ];
    }

    public function save($runValidation = true, $attributes = null)
    {
        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }

        $path = \Yii::getAlias('@webroot');
        $images = UploadedFile::getInstances($this, 'images');
        $imagesGQL = '';
        $imageNodes = '';

        if (!empty($images)) {
            $imagesGQL = ', ';
            $length = count($images);

            for ($i = 0; $i < $length; $i++) {
                $src = '/uploads/' . md5($images[$i]->baseName) . '_' . time() . '.' . $images[$i]->extension;
                $imagesGQL .= "(al)-[:has_image]->(i$i:Image{src:'$src'})";
                $imageNodes .= "i$i";
                // Safe file to uploads dir
                $images[$i]->saveAs($path . $src);
                if ($i != $length - 1) {
                    $imagesGQL .= ',';
                    $imageNodes .= ',';
                }
            }
        }

        $userId = Yii::$app->user->getId();

        if ($attributes == null) {
            $attributes = $this->getAttributesStr($this->attributes());
        }

        return Album::find()
            ->match("(ac:Account{user_id: $userId})")
            ->create("(ac)-[:has_album]->(al:Album{{$attributes}})$imagesGQL")
            ->get('al, ID(al) as id')
            ->one();
    }

    public static function getPhotoCount($user_id = null)
    {
        if(is_null($user_id)){
            $user_id = Yii::$app->user->identity->getId();
        }

        return Album::find()->match("(a:Account{user_id:$user_id}) OPTIONAL MATCH (a)-[:has_album]->(al)
        WITH al OPTIONAL MATCH (al)-[:has_image]->(i) WITH i")
            ->get("count(i) as photoCount")
            ->one()->photoCount;


    }

    public function asArray()
    {
        $identity = $this;
        return ArrayHelper::toArray($identity, [
            'common\models\Album' =>[
                'id',
                'title',
                'hidden',
                'images' => function($identity){
                    return ArrayHelper::toArray($identity->images, [
                        'common\models\Image' => [
                            'src',
                            'description'

                        ]
                    ]);
                }
            ]
        ]);
    }
}