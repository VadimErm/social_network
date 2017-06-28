<?php

namespace common\modules\user\controllers;

use common\models\Album;
use common\models\Image;
use common\models\UploadImage;
use common\models\Account;

use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class ApiController extends Controller
{
    public function actionAddAlbum()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $album = new Album();

        if ($album->load(\Yii::$app->request->post()) && $album->save()) {
            return ['status' => 'success'];
        }

        return ['status' => 'fail'];
    }

    public function actionAppendPhotos()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $image = new UploadImage();
        $image->imageFile = UploadedFile::getInstances($image, 'imageFile');
        $savedFile = $image->uploadMultiple();


        if (is_array($savedFile)) {
            $albumId = \Yii::$app->request->post('album_id');

            $gql = '';

            $length = count($savedFile);

            for ($i = 0; $i < $length; $i++) {
                $gql .= "(a)-[:has_image]->(i$i:Image{src: '/{$savedFile[$i]}'})";

                if ($i < $length - 1) {
                    $gql .= ', ';
                }
            }

            Album::find()
                ->match("(a:Album) WHERE ID(a) = $albumId CREATE $gql")
                ->execute();

            return ['status' => 'success'];
        }

        return ['status' => 'fail'];
    }

    public function actionRemoveAlbum()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $id = \Yii::$app->request->post('id');

        if ($id) {
            Album::find()
                ->match("(n) WHERE ID(n) = $id OPTIONAL MATCH (a:Account)-[ar:has_album]->(n) OPTIONAL MATCH (n)-[r]-(i:Image) DELETE ar, n, r, i")
                ->execute(true);
        }

        return ['status' => 'success'];
    }

    public function actionUpdateAlbum()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $photosData = \Yii::$app->request->post();

        if (!empty($photosData['changed'])) {
            // get data for update description

            foreach ($photosData['changed'] as $photo) {
                Image::find()
                    ->match("(i:Image{src: '{$photo['src']}'}) SET i.description = '{$photo['description']}'")
                    ->execute(true);
            }
        }

        if (!empty($photosData['removed'])) {
            foreach ($photosData['removed'] as $src) {
                Image::find()
                    ->optionalMatch("()-[r:has_image]-(i:Image{src: '$src'}) DELETE i, r")
                    ->execute(true);
            }
        }

        return ['status' => 'success'];
    }

    public function actionMoveAlbum()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $images = \Yii::$app->request->post('photos');
        $from = (int)\Yii::$app->request->post('from');
        $to = (int)\Yii::$app->request->post('to');

        foreach ($images as $image) {
            Album::find()
                ->match("(a)-[rel:has_image]->(i:Image{src: '$image'}) DELETE rel")
                ->get('a')
                ->execute(true);


            Album::find()
                ->match("(a:Album), (i:Image{src:'{$image}'}) WHERE ID(a) = $to CREATE (a)-[:has_image]->(i)")
                ->get('a')
                ->execute(true);
        }

        return ['status' => 'success', "(a:Album) WHERE ID(a) = $from OPTIONAL MATCH (a)-[rel:has_image]->(i:Image{src: '$image'}) DELETE rel"];
    }

    public function actionFollow()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $userIdFollowed = \Yii::$app->request->post('user_id');
        $userId = \Yii::$app->user->id;

      if(Account::find()
        ->match("(a:Account) WHERE a.user_id=$userId MATCH (b:Account) WHERE b.user_id=$userIdFollowed CREATE (a)-[r:follow]->(b)")
        ->get('a')
        ->execute(true)) {

          return ['status' => 'success'];
      } else {
          return ['status' => 'fail'];
      }


    }

    public function actionUnfollow()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $userIdFollowed = \Yii::$app->request->post('user_id');
        $userId = \Yii::$app->user->id;

        if(Account::find()
            ->match("(a:Account{user_id:$userId})-[r:follow]->(b:Account{user_id:$userIdFollowed})   DELETE r")
            ->get('a, b')
            ->execute(true)) {

            return ['status' => 'success'];
        } else {
            return ['status' => 'fail'];
        }

    }
}