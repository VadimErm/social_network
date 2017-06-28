<?php


namespace api\modules\v1\models;

use common\helpers\Base64ToFileHelper;
use common\helpers\Base64ToImageHelper;
use common\helpers\YoutubeParserHelper;
use common\models\Dialog;
use common\models\Message;
use Yii;
use yii\helpers\ArrayHelper;


class MessageRest extends Message
{
    public $imageFiles = [];

    public function insert($runValidation = true, $attributes = null)
    {
        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }


        $dialog = new Dialog();
        $dialog->receiver_id = $this->receiver_id;
        $dialog->author_id = $this->author_id;

        $savedDialog = '';

        if(!$dialog->isExist()){

           $savedDialog = $dialog->insert();

        } else {

            $dialog->resurrect(); //Востанавливаем диалог, если он был удален

        }


        if(is_null($savedDialog))
        {
            return false;
        }

        $path = \Yii::getAlias('@frontend') . '/web';

        $imagesGQL1 = '';
        $imagesGQL2 = '';
        $imageNodes = '';

        if (!empty($this->images)) {

            $images = $this->images;
            $imagesGQL1 = ', ';
            $imagesGQL2 = ', ';
            $length = count($images);

            $i=0;
            $src = [];
            foreach ($images as $key => $image){
                $src[$key] = Base64ToImageHelper::SaveImage($image, $path);
                $imagesGQL1 .= "(m1)-[:has_image]->(i$i:Image{src:'$src[$key]'})";
                $imageNodes .= "i$i";

                if ($key  != $length - 1) {
                    $imagesGQL1 .= ',';
                    $imageNodes .= ',';
                }

                $i++;
            }

            foreach ($images as $key => $image){

                $imagesGQL2 .= "(m2)-[:has_image]->(i$i:Image{src:'$src[$key]'})";

                if ($key != $length - 1) {
                    $imagesGQL2 .= ',';

                }

                $i++;
            }


        }
        $images = empty($imageNodes) ? '' : ", [$imageNodes] as images";

        $videosGQL1 = '';
        $videosGQL2 = '';
        $videoNodes = '';


        if (!empty($this->videos)) {
            $videos  = $this->videos;
            $srcVideo = [];
            $videosGQL1 = ', ';
            $videosGQL2 = ', ';
            $length = count($this->videos);
            $j = 0;

            foreach ($videos as $key => $video){
                $srcVideo[$key] = YoutubeParserHelper::parse($video);
                $videosGQL1 .= "(m1)-[:has_video]->(v$j:Video{src:'{$srcVideo[$key]}'})";
                $videoNodes .= "v$j";

                if ($key != $length - 1) {
                    $videosGQL1 .= ',';
                    $videoNodes .= ',';
                }

                $j++;

            }

            foreach ($videos as $key => $video){

                $videosGQL2 .= "(m2)-[:has_video]->(v$j:Video{src:'{$srcVideo[$key]}'})";

                if ($key != $length - 1) {
                    $videosGQL2 .= ',';

                }

                $j++;
            }

        }

        $videos = empty($videoNodes) ? '' : ", [$videoNodes] as videos";

        $filesGQL1 = '';
        $filesGQL2 = '';
        $fileNodes = '';

        if(!empty($this->files)){

            $files = $this->files;
            $filesGQL1 = ', ';
            $filesGQL2 = ', ';
            $length = count($files);

            $i=0;
            $src = [];
            foreach ($files as $key => $file){
                $src[$key] = Base64ToFileHelper::SaveFile($file, $path);
                $filesGQL1 .= "(m1)-[:has_file]->(i$i:File{path:'$src[$key]'})";
                $fileNodes .= "i$i";

                if ($key  != $length - 1) {
                    $filesGQL1 .= ',';
                    $fileNodes .= ',';
                }

                $i++;
            }

            foreach ($files as $key => $file){

                $filesGQL2 .= "(m2)-[:has_file]->(i$i:File{path:'$src[$key]'})";

                if ($key != $length - 1) {
                    $filesGQL2 .= ',';

                }

                $i++;
            }

        }

        $files = empty($fileNodes) ? '' : ", [$fileNodes] as files";

        if ($attributes == null) {
            $attributes = $this->getAttributesStr($this->attributes());
        }


        $username = Yii::$app->user->identity->username;

        $time = (int) time();
        $token =md5(rand().time().md5($username));

        $attributes = '{' . $attributes . ', created_at: ' . $time . ', readed: ' . self::UNREADED . ', token: "'.$token.'"}';



        return Message::find()
            ->match("(a:Account{user_id:$this->author_id})-[hd1:has_dialog]->(d1:Dialog)-[:link]-(d2:Dialog)<-[hd2:has_dialog]-(b:Account{user_id:$this->receiver_id}) 
            CREATE (d1)-[:has_message]->(m1:Message{$attributes})$imagesGQL1$videosGQL1$filesGQL1, 
            (d2)-[:has_message]->(m2:Message{$attributes})$imagesGQL2$videosGQL2$filesGQL2")
            ->get("m1, a as author, ID(m1) as id$images$videos$files")
            ->one();


    }




}