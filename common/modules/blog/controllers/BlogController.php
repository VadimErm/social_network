<?php

namespace common\modules\blog\controllers;

use common\models\Account;
use common\models\Post;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class BlogController extends Controller
{
    public function actionIndex()
    {
    }

    public function actionAddPost()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

//        return [\Yii::$app->request->post()];
        $userId = \Yii::$app->user->identity->getId();
        $post = new Post();
        $post->load(\Yii::$app->request->post());


        $post->user_id = $userId;
        $deletedImages =[];

        if (!empty(\Yii::$app->request->post('deleted_images'))) {
            $deletedImages = \Yii::$app->request->post('deleted_images');
        }

        if(!$post->validate()){
            return ['status' => 'fail', 'errors' => $post->getErrors()];
        }

        $attributes = $post->attributes();

        $attributes = $post->getAttributesStr($attributes);


        //$userIp = \Yii::$app->request->getUserIP();
        //$time = time() - \Yii::$app->request->post('local_time') * 60;
        $time = time();

        $attributes = '{'.$attributes.', created_at: '.$time.'}';

        $videosGQL = '';

        if (!empty(\Yii::$app->request->post('Post')['videos'])) {
            $videos = \Yii::$app->request->post('Post')['videos'];
            $videosGQL = 'CREATE ';

            $length = count($videos);

            for ($i = 0; $i < $length; $i++) {
                $videosGQL .= " (p)-[:has_video]->(v$i:Video{src:'{$videos[$i]}'})";

                if ($i != $length - 1) {
                    $videosGQL .= ',';
                }
            }
        }

        $images = UploadedFile::getInstances($post, 'images');

        $imagesGQL = '';
        $imageNodes = '';
        $path = \Yii::getAlias('@webroot');

        if (!empty($images)) {
            $length = count($images);

            for ($i = 0; $i < $length; $i++) {
                $date = new \DateTime();

                if(!in_array($images[$i]->baseName. '.' . $images[$i]->extension, $deletedImages)) {

                    $src = '/uploads/' . md5($images[$i]->baseName) .$date->getTimestamp().'.' . $images[$i]->extension;
                    $imagesGQL .= "(i$i:Image{src:'$src'})<-[:has_image]-(p)";
                    $imageNodes .= "i$i";
                    // Safe file to uploads dir
                    $images[$i]->saveAs($path . $src);
                    if ($i != $length - 1) {
                        $imagesGQL .= ',';
                        $imageNodes .= ',';
                    }
                }
            }

            $imagesGQL = ", $imagesGQL";
        }
        //Check if last symbol is ',' and delete it
        if($imageNodes !== '' && $imagesGQL !== '') {
            if ($imageNodes[strlen($imageNodes) - 1] == ',') {
                $imageNodes = substr($imageNodes, 0, -1);
            }
            if($imagesGQL[strlen($imagesGQL) -1] == ',') {
                $imagesGQL = substr($imagesGQL, 0, -1);
            }
        }



        $images = empty($imageNodes) ? '': ", [$imageNodes] as images";

        $post = Post::find()
            ->match("(a:Account{user_id:$userId})-[h:has_blog]->(b) CREATE (p: Post$attributes), (b)-[:has_post]->(p)$imagesGQL$videosGQL")
            ->get("p, ID(p) as id$images")
            ->one();

        $account = Account::find()
            ->match("(a:Account{user_id:$userId})")
            ->get('a')
            ->one();

        return [
            'status' => 'success',
            'account' => json_encode($account),
            'post' => json_encode($post)];
    }


    public function actionUpdatePost()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $postId = \Yii::$app->request->post('post_id');
        $title = \Yii::$app->request->post('Post')['title'];
        $message = \Yii::$app->request->post('Post')['message'];

        $oldImages = [];

        if (!empty(\Yii::$app->request->post('old_images'))) {
            $oldImages = \Yii::$app->request->post('old_images');
        }


        $deletedImages =[];

        if (!empty(\Yii::$app->request->post('deleted_images'))) {
            $deletedImages = \Yii::$app->request->post('deleted_images');
        }

        $post = new Post();

        $post->load(\Yii::$app->request->post());

        if(!$post->validate()){
            return ['status' => 'fail', 'errors' => $post->getErrors()];
        }

        $videosGQL = '';

        if (!empty(\Yii::$app->request->post('Post')['videos'])) {
            $videos = \Yii::$app->request->post('Post')['videos'];

            foreach ($videos as $key => $video) {
                $videosGQL .= " MERGE (p)-[:has_video]->(v$key:Video{src:'{$video}'})";


            }
        }

        $newImages = UploadedFile::getInstances($post, 'images');

        $imagesGQL = '';

        $path = \Yii::getAlias('@webroot');
        $images = array_merge($oldImages, $newImages);
        if(!empty($images)){



            foreach ($images as $key => $image) {
                $date = new \DateTime();
                //check if $image is new uploaded image
                if($image instanceof UploadedFile){
                    if(!in_array($image->baseName. '.' . $image->extension, $deletedImages)) {
                        $src = '/uploads/' . md5($image->baseName) . $date->getTimestamp() . '.' . $image->extension;
                        $image->saveAs($path . $src);
                    }
                } else{
                    $src = $image;
                }


                $imagesGQL .= " MERGE (i$key:Image{src:'$src'})<-[:has_image]-(p)";
            }


        }

        $post = Post::find()->match("(p:Post) OPTIONAL MATCH (p)-[r:has_image|:has_video]-(n) WHERE ID(p)=$postId DELETE  r $imagesGQL $videosGQL")

            ->set('p.title="'.$title.'", p.message="'.$message.'"')

            ->get('p')
            ->one();

        if($post){
            return ['status'=>'success'];
        } else {
            return ['status' => 'fail'];
        }




    }
}