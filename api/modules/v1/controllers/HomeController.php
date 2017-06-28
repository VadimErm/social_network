<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 21.06.17
 * Time: 18:29
 */

namespace api\modules\v1\controllers;

use common\models\City;
use common\models\Journal;
use common\models\Post;
use Yii;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
use yii\rest\Controller;
use yii\web\Response;

class HomeController extends Controller
{
    public function behaviors()
    {


        $behaviors['bootstrap'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]

        ];

        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [

                'index'         => ['get'],



            ],
        ];

        return $behaviors;
    }

    /**
     * Data for home page
     * @return array
     * @method GET
     * @link /api/v1/homes
     */
    public function actionIndex()
    {
        $modelCity = new City();
        $cities  = $modelCity->getAll();

        $journalsArr = [];
        $blogsArr = [];

        $journals = Journal::getAllJournals();

        $posts = Post::getAll();

        if(!empty($posts)){

            foreach ($posts as $key => $post){

                $blogsArr[$key]['id'] = $post['id'];
                $blogsArr[$key]['title'] = $post['title'];
                $blogsArr[$key]['image'] = array_shift($post['images'])['src'];
                $blogsArr[$key]['account'] = $post['account'];

            }
        }


        if(!empty($journals)){

            foreach ($journals as $key => $journal){

                $journalsArr[$key]['id'] = $journal->car['id'];
                $journalsArr[$key]['car_name'] = $journal->car['car_name'];
                $journalsArr[$key]['about'] = $journal->car['about'];
                $journalsArr[$key]['image'] = array_shift($journal->car['images'])['src'];
                $journalsArr[$key]['likes'] = $journal->likes;
                $journalsArr[$key]['favorites'] = $journal->favorites;
                $journalsArr[$key]['views'] = $journal->views;

            }
        }

        return [
            'cities' => $cities,
            'journals' => $journalsArr,
            'blogs' => $blogsArr,
            'communities' => [],
            'companies' => [],
            'promo' => []
        ];

    }

}