<?php

namespace common\modules\user\controllers;

use common\models\Album;
use yii\web\Controller;

class AlbumController extends Controller
{
    public function actionIndex()
    {
        $userId = \Yii::$app->user->getId();

        $albums = Album::find()
            ->match("(ac:Account{user_id: $userId})-[:has_album]->(al)")
            ->optionalMatch('(al)-[:has_image]->(i)')
            ->get('al, collect(i) as images ORDER BY ID(al) ASC')
            ->all();
        $defaultAlbums = [0 => '', 1 => ''];
        $customAlbums = [];

        foreach ($albums as $album) {
            if ($album->title == 'Saved photos') {
                $defaultAlbums[0] = $album;
            } elseif ($album->title == 'All photos') {
                $defaultAlbums[1] = $album;
            } else {
                $customAlbums[] = $album;
            }
        }

        return $this->render('albums', ['albums' => array_merge($defaultAlbums, $customAlbums)]);
    }

    public function actionPhotos()
    {
        return $this->render('photos');
    }

    public function actionSingle($id)
    {
        $album = Album::find()
            ->match("(a:Album) WHERE ID(a) = $id")
            ->optionalMatch('(a)-[:has_image]->(i)')
            ->get('a, collect(i) as images')
            ->one();

        $all_photos = false;

        if ($album->title == 'All photos') {
            $all_photos = true;

            $userId = \Yii::$app->user->getId();

            $albums = Album::find()
                ->match("(ac:Account{user_id:$userId})-[:has_album]->(a:Album)")
                ->optionalMatch('(a)-[:has_image]->(i)')
                ->get('a, collect(i) as images')
                ->all();

            foreach ($albums as $a) {
                foreach ($a->images as $image) {
                    $album->images[] = $image;
                }
            }
        }

        return $this->render('single_album', [
            'id' => $album->id,
            'album_title' => $album->title,
            'images' => $album->images,
            'all_photos' => $all_photos,
            'albums' => $albums = Album::find()
                ->match('(a:Album)')
                ->get('a')
                ->all()
        ]);
    }

    public function actionEdit($id)
    {
        $userId = \Yii::$app->user->getId();

        $albums = Album::find()
            ->match("(ac:Account{user_id: $userId})-[:has_album]->(a:Album)")
            ->get('a')
            ->all();


        $album = Album::find()
            ->match("(a:Album) WHERE ID(a) = $id")
            ->optionalMatch('(a)-[:has_image]->(i)')
            ->get('a, collect(i) as images')
            ->one();

        $images = $album->images;

        foreach ($albums as $album) {
            if ($album->title == 'All photos') {
                $all_albums_id = $album->id;
            }
        }

        return $this->render('edit', [
            'id' => $album->id,
            'images' => $images,
            'albums' => $albums,
            'all_albums_id' => $all_albums_id
        ]);
    }
}