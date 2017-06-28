<?php


namespace api\controllers;



use Faker\Provider\DateTime;
use Imagine\Exception\RuntimeException;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;




class ImageResizeController extends Controller
{

    CONST UPLOAD_DIR  = '/uploads/';
    CONST ALIAS= '@frontend/web';


    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],

            ],
        ];

    }


    public function actionUploadImage()
    {

        if(\Yii::$app->request->isPost) {

            $imageFiles = UploadedFile::getInstancesByName('image');

            $path = \Yii::getAlias(self::ALIAS);
            $response = [];

            for($i = 0; $i < count($imageFiles); $i++){

                $name = md5($imageFiles[$i]->baseName) . '.' . $imageFiles[$i]->extension;
                $src = self::UPLOAD_DIR . $name;
                if($imageFiles[$i]->saveAs($path.$src)){
                    $response[$i]['url'] = $src;


                }

            }


            return $response;

        }

    }

    public function actionCropImage()
    {
        $request = \Yii::$app->request;
        if(\Yii::$app->request->isPost) {

            $data = \Yii::$app->request->post('data');
            $imgUrl = $data['imgUrl'];
            $imgW = $data['imageData']['naturalWidth'];
            $imgH = $data['imageData']['naturalHeight'];
            $imgX1 = $data['cropperData']['x'];
            $imgY1 = $data['cropperData']['y'];
            $cropW = $data['cropperData']['width'];
            $cropH = $data['cropperData']['height'];

            $imagine =  Image::getImagine();

            $newImage = $imagine->open(\Yii::getAlias(self::ALIAS).$imgUrl);

            //Create new path for image
            $timestamp = DateTime::unixTime();
            $arr = explode('.',$imgUrl);
            $pathWithoutExtension = $arr[0];
            $extension = $arr[1];
            $newImgUrl = $pathWithoutExtension.'?'.$timestamp.'.'.$extension;

            try {

                $newImage->resize(new Box($imgW, $imgH))
                    ->crop(new Point($imgX1, $imgY1), new Box($cropW, $cropH))
                    ->save(\Yii::getAlias(self::ALIAS).$imgUrl);
                $response = [
                    "status" => "success",
                    "url" => $imgUrl
                ];
            } catch (RuntimeException $e) {

                $message = $e->getMessage();
                $response = [
                    "status" => "error",
                    "message" => $message
                ];

            }
        }
        return $response;



    }

}