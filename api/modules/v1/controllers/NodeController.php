<?php


namespace api\modules\v1\controllers;

use api\filters\auth\HttpBearerAuth;

use common\models\Node;
use common\models\Notification;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\web\Response;


class NodeController extends Controller
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
                    'actions' => ['create', 'get-node', 'delete-node'],
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

                'create'    => ['post'],
                'get-node'  => ['get'],
                'delete-node' => ['delete']



            ],
        ];

        return $behaviors;
    }

    /**
     * @param $id
     * @param $node_type
     * @return array
     * @path api/v1/nodes/get-node/<id>/<node_type>
     * @method GET
     */
    public function actionGetNode($id, $node_type)
    {

        $model = new Node();

        $node = $model->getNode($id, $node_type, true);

        if($node){
            return [
                'status' => 'success',
                'node' => $node,
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        } else {
            return [
                'status' => 'fail',

                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }


    }

    /**
     * @param $id
     * @param $node_type
     * @return array
     * @path api/v1/nodes/delete-node/<id>/<node_type>
     * @method DELETE
     */
    public function actionDeleteNode($id, $node_type)
    {
        $model = new Node();

        $node = $model->getNode($id, $node_type);

        if($node){
            if($node->del()){
                return [
                    'status' => 'success',
                    'access_token' => Yii::$app->user->identity->getAuthKey()

                ];
            } else {
                return [
                    'status' => 'fail',
                    'access_token' => Yii::$app->user->identity->getAuthKey()
                ];
            }
        } else {
            return [
                'status' => 'fail',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }




    }

}