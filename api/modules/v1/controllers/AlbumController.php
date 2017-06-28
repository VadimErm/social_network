<?php


namespace api\modules\v1\controllers;

use api\modules\v1\models\AlbumRest;
use api\modules\v1\models\UploadImageRest;
use common\models\Album;
use common\models\Image;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use api\filters\auth\HttpBearerAuth;
//use yii\rest\Controller;
use yii\web\Response;

class AlbumController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
            ],

        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [

                [
                    'allow' => true,
                    'actions' => ['index', 'create', 'update', 'delete', 'view', 'upload-photos', 'edit', 'photo-count'],
                    'roles' => ['@'],
                ],
            ],
        ];

        $behaviors['bootstrap'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]

        ];

        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [

                'index'    => ['get'],
                'create'   => ['post'],
                'delete'   => ['delete'],
                'edit'    => ['patch'],
                'view'     => ['get'],
                'upload-photos' => ['post'],
                'photo-count'   => ['get']



            ],
        ];

        return $behaviors;
    }

    /**
     * Get user's albums
     * @return array
     * @method get
     * /api/v1/albums
     */
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
                $defaultAlbums[0] = $album->asArray();
            } elseif ($album->title == 'All photos') {
                $defaultAlbums[1] = $album->asArray();
            } else {
                $customAlbums[] = $album->asArray();
            }
        }

        //Breadcrumbs

        $this->breadcrumbs->addCrumb("My profile", '/api/v1/account/profile');
        $this->breadcrumbs->addCrumb("My photo albums");


        return [
            'status' => 'success',
            'albums' =>array_merge($defaultAlbums, $customAlbums),
            'access_token' => Yii::$app->user->identity->getAuthKey(),
            'breadcrumbs' => $this->breadcrumbs->getBreadcrumbs(),
        ];
    }

    /**
     * Create new album
     * @return array
     * @method post
     * /api/v1/albums
     * Fields:
     * AlbumRest[title]
     * AlbumRest[imageFiles][] - in base64
     * AlbumRest[hidden] - add this field  if album is hidden
     */
    public function actionCreate()
    {

        $album = new AlbumRest();


        if ($album->load(\Yii::$app->request->post()) && $savedAlbum =  $album->save()) {
            return [
                'status' => 'success',
                'album' => $savedAlbum->asArray(),
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return ['status' => 'fail', 'access_token' => Yii::$app->user->identity->getAuthKey()];
    }

    /**
     * Edit album
     * @return array
     *'/api/v1/albums/edit'
     * Fields:
     * removed[] - set if some images removed
     * changed[][src] - set if changed description
     * changed[][description] - set if changed description
     */
    public function actionEdit()
    {

        $photosData = \Yii::$app->request->post();

       if (!empty($photosData['changed'])) {


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



        return ['status' => 'success',  'access_token' => Yii::$app->user->identity->getAuthKey()];
    }

    /**
     * View user's album by $id
     * @param $id
     * @return array
     * @method get
     * /api/v1/albums/<id>
     */
    public function actionView($id)
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

        //Breadcrumbs

        $this->breadcrumbs->addCrumb("My profile", '/api/v1/account/profile');
        $this->breadcrumbs->addCrumb("My photo albums", '/api/v1/albums');
        $this->breadcrumbs->addCrumb($album->title);

        return [
            'status' => 'success',
            'album' => $album->asArray(),
            'all_photos' => $all_photos,
            'breadcrumbs' => $this->breadcrumbs->getBreadcrumbs(),
            'access_token' => Yii::$app->user->identity->getAuthKey()

        ];

    }

    /**
     * Upload photos to user's album
     * @return array
     * @method POST
     * /api/v1/albums/upload-photos
     * Fields:
     * images[] - in base64
     * album_id
     */

    public function actionUploadPhotos()
    {

        $image = new UploadImageRest(\Yii::$app->request->post('images'));
        $savedFiles = $image->uploadMultiple();


        if (is_array($savedFiles)) {

            $albumId = \Yii::$app->request->post('album_id');

            $gql = '';

            $length = count($savedFiles);

            for ($i = 0; $i < $length; $i++) {
                $gql .= "(a)-[:has_image]->(i$i:Image{src: '{$savedFiles[$i]}'})";

                if ($i < $length - 1) {
                    $gql .= ', ';
                }
            }

            $album = Album::find()
                ->match("(a:Album) WHERE ID(a) = $albumId  CREATE $gql WITH a")
                ->optionalMatch('(a)-[:has_image]->(i)')
                ->get('a, collect(i) as images')
                ->one();

            return [
                'status' => 'success',
                'album' => $album->asArray(),
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return ['status' => 'fail', 'access_token' => Yii::$app->user->identity->getAuthKey()];
    }

    /**
     * Delete user's album by $id
     * @param $id
     * @return array
     * @method DELETE
     * /api/v1/albums/$id
     */
    public function actionDelete($id)
    {

        if($album =  Album::find()
                ->match("(n) WHERE ID(n) = $id OPTIONAL MATCH (a:Account)-[ar:has_album]->(n) OPTIONAL MATCH (n)-[r]-(i:Image) DELETE ar, n, r, i")
               ->get('ID(n) as id')
               ->one())
        {
            return ['status' => 'success',  'access_token' => Yii::$app->user->identity->getAuthKey()];
        }

        return ['status' => 'fail', 'access_token' => Yii::$app->user->identity->getAuthKey()];

    }

    /**
     * Get photo count
     * @return array
     * @method GET
     * /api/v1/albums/photo-count
     */
    public function actionPhotoCount()
    {
        if($count = Album::getPhotoCount()){
            return [
                'status' =>'success',
                'photo_count' => $count,
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return [
            'status' => 'success',
            'photo_count' => 0,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }
}