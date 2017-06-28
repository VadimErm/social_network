<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 06.06.17
 * Time: 13:16
 */

namespace api\modules\v1\controllers;

use Creitive\Breadcrumbs\Breadcrumbs;
use yii\base\Module;
use yii\rest\Controller as RestController;

class Controller extends RestController
{

    public $breadcrumbs;
    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->breadcrumbs = new Breadcrumbs;
        $this->breadcrumbs->addCrumb('Main', '/');
    }
}