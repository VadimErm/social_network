<?php


namespace api\modules\v1\controllers;

use api\modules\v1\models\JournalEntryRest;
use common\models\Comment;
use common\models\Journal;
use common\models\JournalEntry;
use common\models\Tag;
use Yii;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
use yii\rest\Controller;
use yii\web\Response;

class JournalController extends Controller
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
                    'actions' => ['index', 'create', 'update', 'view', 'delete', 'user-journals', 'add-views', 'count', 'add-views-to-journal'],
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
                'update'   => ['patch'],
                'view'     => ['get'],
                'delete'   => ['delete'],
                'user-journals' => ['get'],
                'add-views' => ['put'],
                'count'     => ['get'],
                'add-views-to-journal' => ['put']



            ],
        ];

        return $behaviors;
    }

    /**
     * Get list of journals with filtering by get parameter sort, skip, limit
     * @return array
     * @method get
     * /api/v1/journals?sort=xxx&skip=xxx&limit=xxx
     *
     */
    public function actionIndex()
    {

       $journals =  Journal::getAll();

        return [
            'status' =>'success',
            'journals' => $journals,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }

    /**
     * Create new journal
     * @return array
     * @method post
     * /api/v1/journals
     * Fields:
     * JournalEntryRest[title]
     * JournalEntryRest[text]
     * JournalEntryRest[language]
     * JournalEntryRest[type]
     * JournalEntryRest[mileage]
     * JournalEntryRest[expenses]
     * JournalEntryRest[currency]
     * JournalEntryRest[hidden]
     * JournalEntryRest[images_base64][] - in base64
     * JournalEntryRest[tags][]
     * JournalEntryRest[journal_id]
     *
     */
    public function actionCreate()
    {

        $journalEntry = new JournalEntryRest();

        if(isset(Yii::$app->request->post('JournalEntryRest')['tags'])){
            $tags = Yii::$app->request->post('JournalEntryRest')['tags'];
        }

        if($journalEntry->load(Yii::$app->request->post()) && $journalEntrySaved = $journalEntry->insert()){
            $journalEntrySavedId = $journalEntrySaved->id;
            if(!empty($tags)){
                $tag = new Tag();
                $tag->add($tags, $journalEntrySavedId);
                $journalEntrySaved->tags = $journalEntrySaved->getTags();
            }

            return  [
                'status' =>'success',
                'journal_entry' => $journalEntrySaved->asArray(),
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];

        }


        return [
            'status' =>'fail',
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }


    /**
     * View journal by $id
     * @param $id - id of journal
     * @return array
     * @method get
     *
     * /api/v1/journals/$id?skip=xxx&limit=xxx&sort=xxx
     */
    public function actionView($id)
    {

        $newJournal = new Journal();

        $skip = null;
        $limit = null;
        $sort = JournalEntry::SORT_BY_NAME;

        if(isset($_GET['sort'])){
            $sort = $_GET['sort'];
        }

        if(isset($_GET['skip']) && isset($_GET['limit'])){
            $skip = $_GET['skip'];
            $limit = $_GET['limit'];
        }
        if($journal = $newJournal->findById($id)){



            return [
                'status' =>'success',
                'journal' => $journal->asArray($skip, $limit, $sort),
                'car'     => $journal->getCar()->asArray(['journal']),

                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return [
            'status' =>'fail',
            'error' => "Journal not found",
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];




    }
    /**
     * Update journal
     * @return array
     * @method patch
     * /api/v1/journals/<id>
     * Fields:
     * JournalEntryRest[title]
     * JournalEntryRest[text]
     * JournalEntryRest[language]
     * JournalEntryRest[type]
     * JournalEntryRest[mileage]
     * JournalEntryRest[expenses]
     * JournalEntryRest[currency]
     * JournalEntryRest[hidden]
     * JournalEntryRest[images_base64][] - new images in base64, old images as path to it
     * JournalEntryRest[tags][]
     *
     */
    public function actionUpdate($id)
    {
        $journalEntry = new JournalEntryRest();
        if(isset(Yii::$app->request->post('JournalEntryRest')['tags'])){
            $tags = Yii::$app->request->post('JournalEntryRest')['tags'];
        }

        $journalEntry->id = $id;

        if($journalEntry->load(Yii::$app->getRequest()->getBodyParam('JournalEntryRest'), '') && $journalEntrySaved = $journalEntry->update(false)){

            if(!empty($tags)){
                $tag = new Tag();
                $tag->add($tags, $id);
                $journalEntrySaved->tags = $journalEntrySaved->getTags();
            }


            return  [
                'status' =>'success',
                'journal_entry' => $journalEntrySaved->asArray(),
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return [
            'status' =>'fail',
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }

    /**
     * Delete journal by $id
     * @param $id
     * @return array
     * @method delete
     * /api/v1/journals/$id
     */
    public function actionDelete($id)
    {
        $userId = Yii::$app->user->identity->getId();

        $model= new JournalEntry();
        if($journalEntry = $model->findById($id)) {
            if($userId == $journalEntry->getJournal()->getAccount()->user_id){

                if($journalEntry->del()){

                    return [
                        'status' =>'success',
                        'access_token' => Yii::$app->user->identity->getAuthKey()
                    ];

                } else {
                    return [
                        'status' =>'fail',
                        'access_token' => Yii::$app->user->identity->getAuthKey()
                    ];
                }

            } else {
                return [
                    'status' =>'fail',
                    'error' => "You don't have permissions to delete this journal entry",
                    'access_token' => Yii::$app->user->identity->getAuthKey()
                ];
            }
        }

        return [
            'status' =>'fail',
            'error' => "This journal entry does't exist",
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];


    }

    /**
     * Increment views's count on 1 when user click 'Read'
     * @param $id - id of journal entry
     * @return array
     * @method put
     * /api/v1/journals/add-views/<id>
     */
    public function actionAddViews($id)
    {
        $model = new JournalEntry();

        $status = 'fail';

        if($journalEntry = $model->findById($id)){
            if($journalEntry->addViews()){
                $status = 'success';
            }
        }

        return [
            'status' => $status,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }

    /**
     * Add views to journal
     * @return array
     * @param journal_id
     * @method PUT
     * @link /api/v1/journals/add-views-to-journal
     */
    public function actionAddViewsToJournal()
    {
        $journalId = Yii::$app->getRequest()->getBodyParam('journal_id');
        $model = new Journal();
        $status = 'fail';

        if($journal = $model->findById($journalId)){

            if($journal->addViews()){
                $status = 'success';
            }

        }

        return [
            'status' => $status,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];


    }

    /**
     * View user's journals by user_id, filtering by get parameters sort, skip, limit
     * @param $user_id - id of user who you view
     * @return array
     * @method get
     * /api/v1/journals/user-journals/$user_id?sort=xxx&skip=xxx&limit=xxx
     */
    public function actionUserJournals($user_id)
    {
        return [
            'status' =>'success',
            'journals' => [],
            'user_id' => $user_id,
            'query' => $_GET,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }


    /**
     * Get journals count
     * @return array
     * @method GET
     * /api/v1/journals/count
     */
    public function actionCount()
    {
        if($count = Journal::getCount()){
            return [
                'status' =>'success',
                'journal_count' => $count,
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return [
            'status' => 'success',
            'journal_count' => 0,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }


}