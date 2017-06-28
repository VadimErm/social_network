<?php


namespace api\modules\v1\controllers;

use common\helpers\YoutubeParserHelper;
use common\models\Account;
use common\models\Post;
use Yii;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use common\helpers\Base64ToImageHelper;


class BlogController extends Controller
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
                    'actions' => ['index', 'create', 'update', 'delete'],
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
                'update'    => ['patch'],

            ],
        ];

        return $behaviors;
    }

    /**
     * Get user's blog's posts filtering by skip and limit
     * @return array
     * @method get
     * /api/v1/blogs?skip=xxx&limit=xxx
     */

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $userId = $user->getId();
        $postsArr = [];
        $returnQuery =  'p, ID(p) as id, images,  comments,  videos ORDER BY ID(p)';
        $skip = '';
        $limit = '';
        if(isset($_GET['skip']) && isset($_GET['limit'])){
            $skip = $_GET['skip'];
            $limit = $_GET['limit'];
        }


        if( !empty($skip) && !empty($limit)){
            $returnQuery .= " SKIP $skip LIMIT $limit";
        }

        $posts = Post::find()
            ->match("(a:Account{user_id:$userId})-[:has_blog]->(b)-[:has_post]->(p) 
                OPTIONAL MATCH (a)-[:has_blog]->(b)-[:has_post]->(p)-[:has_image]->(i) WITH p, a, collect(i) as images
                OPTIONAL MATCH (a)-[:has_blog]->(b)-[:has_post]->(p)-[:has_comment]->(c) WITH p, a, images, collect(c) as comments
                OPTIONAL MATCH (a)-[:has_blog]->(b)-[:has_post]->(p)-[:has_video]->(v) WITH p, a, images, comments,  collect(v) as videos
            ")
            ->get($returnQuery)
            ->all();

        if(!empty($posts)) {
            foreach ($posts as $post) {


                $postsArr[] = $post->asArray();
            }
        }

        return ['status' => 'success', 'posts' =>$postsArr, 'access_token' => $user->getAuthKey()];

    }

    /**
     * Create new post in blog
     * @return array
     * @method post
     * /api/v1/blogs
     * Fields:
     * Post[title]
     * Post[message]
     * Post[videos][]
     * Post[images][] - in base64
     */
    public function actionCreate()
    {

        $userId = \Yii::$app->user->identity->getId();
        $post = new Post();
        $post->load(\Yii::$app->request->post());
        $post->user_id = $userId;

        if(!$post->validate()){
            return ['status' => 'fail', 'errors' => $post->getErrors()];
        }

        $attributes = $post->attributes();

        $attributes = $post->getAttributesStr($attributes);

        $time = time();

        $attributes = '{'.$attributes.', created_at: '.$time.'}';

        $videosGQL = '';
        $videos = '';

        if (!empty(\Yii::$app->request->post('Post')['videos'])) {
            $videos = \Yii::$app->request->post('Post')['videos'];
            $videosGQL = 'CREATE ';
            $videoNodes = '';

            $length = count($videos);

            for ($i = 0; $i < $length; $i++) {
                $videoUrl = YoutubeParserHelper::parse($videos[$i]);
                $videosGQL .= " (p)-[:has_video]->(v$i:Video{src:'{$videoUrl}'})";
                $videoNodes .= "v$i";

                if ($i != $length - 1) {
                    $videosGQL .= ',';
                    $videoNodes .= ',';
                }
            }

            //Check if last symbol is ',' and delete it
            if($videoNodes !== '' && $videosGQL !== '') {
                if ($videoNodes[strlen($videoNodes) - 1] == ',') {
                    $videoNodes = substr($videoNodes, 0, -1);
                }
                if($videosGQL[strlen($videosGQL) -1] == ',') {
                    $videosGQL = substr($videosGQL, 0, -1);
                }
            }

            $videos= empty($videoNodes) ? '': ", [$videoNodes] as videos";
        }

        $images = '';
        $imagesGQL = '';
        if(!empty(\Yii::$app->request->post('Post')['images']))
        {
            $images = \Yii::$app->request->post('Post')['images'];

            $imageNodes = '';
            $path = \Yii::getAlias('@frontend').'/web';

            if (!empty($images)) {
                $length = count($images);

                for ($i = 0; $i < $length; $i++) {

                    if($src = Base64ToImageHelper::SaveImage($images[$i], $path)){
                        $imagesGQL .= "(i$i:Image{src:'$src'})<-[:has_image]-(p)";
                        $imageNodes .= "i$i";

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
        }


        if($post = Post::find()
            ->match("(a:Account{user_id:$userId})-[h:has_blog]->(b) CREATE (p: Post$attributes), (b)-[:has_post]->(p)$imagesGQL$videosGQL")
            ->get("p, ID(p) as id$images$videos")
            ->one())
        {

            return [
                'status' => 'success',
                'post' => $post->asArray(),
                'access_token' =>\Yii::$app->user->identity->getAuthKey(),

            ];
        }


            return [
                'status' => 'fail',
                'access_token' =>\Yii::$app->user->identity->getAuthKey(),

            ];




    }

    /**Delete post by $id
     * @param $id
     * @return array|string
     * @method delete
     * /api/v1/blogs/$id
     */
    public function actionDelete($id)
    {

        try {
            Post::find()
                ->match("(n) WHERE ID(n) = $id OPTIONAL MATCH (n)-[r]-() DELETE n,r")
                ->one();
        } catch (\Exception $e) {
            return 'Neo4j error';
//            throw $e;
            // TODO remove throw, change to pretty error page)
        }



        return ['status' => 'success', 'access_token' => \Yii::$app->user->identity->getAuthKey()];
    }

    /**
     * Update post by $id
     * @param $id
     * @return array
     * @method patch
     * /api/v1/blogs/$id
     * Fields:
     * Post[title]
     * Post[message]
     * Post[videos][]
     * Post[images][] - in base64
     * old_images[] - path to images that exist
     *
     */
    public function actionUpdate($id)
    {


        $title = \Yii::$app->getRequest()->getBodyParam('Post')['title'];
        $message = \Yii::$app->getRequest()->getBodyParam('Post')['message'];

        $oldImages = [];
        $newImages = [];

        $model = new Post();

        $model->load(Yii::$app->getRequest()->getBodyParam('Post'), '');

        if(!$model->validate()){
            return ['status' => 'fail', 'errors' => $model->getErrors(), 'access_token' =>\Yii::$app->user->identity->getAuthKey()];
        }

        $videosGQL = '';

        if (!empty(\Yii::$app->getRequest()->getBodyParam('Post')['videos'])) {

            $videos = \Yii::$app->getRequest()->getBodyParam('Post')['videos'];

            foreach ($videos as $key => $video) {
                $videoUrl = YoutubeParserHelper::parse($video);
                $videosGQL .= " MERGE (p)-[:has_video]->(v$key:Video{src:'{$videoUrl}'})";


            }
        }

        $imagesGQL = '';

        $path = \Yii::getAlias('@frontend').'/web';

        if (!empty(\Yii::$app->getRequest()->getBodyParam('old_images'))) {
            $oldImages = \Yii::$app->getRequest()->getBodyParam('old_images');

        }

        if(!empty(\Yii::$app->getRequest()->getBodyParam('Post')['images'])){

            $newImages = \Yii::$app->getRequest()->getBodyParam('Post')['images'];

        }

        $images = array_merge($oldImages, $newImages);

        if(!empty($images)){
            foreach ($images as $key => $image){
                if(base64_decode($image, true) !== false){
                    if($src = Base64ToImageHelper::SaveImage($image, $path)){
                        $imagesGQL .= " MERGE (i$key:Image{src:'$src'})<-[:has_image]-(p)";
                    }
                } else {
                    $imagesGQL .= " MERGE (i$key:Image{src:'$image'})<-[:has_image]-(p)";
                }
            }
        }


        $post = Post::find()->match("(p:Post) OPTIONAL MATCH (p)-[r:has_image|:has_video]-(n) WHERE ID(p)=$id DELETE  r $imagesGQL $videosGQL")

            ->set('p.title="'.$title.'", p.message="'.$message.'"')

            ->get('p')
            ->one();

        if($post){
            //TODO: добавить в ответ $post с картинками и видео
            return ['status' =>'success', 'post' => $post->asArray(),  'access_token' =>\Yii::$app->user->identity->getAuthKey()];
        } else {
            return ['status' => 'fail', 'access_token' =>\Yii::$app->user->identity->getAuthKey()];
        }


    }


}