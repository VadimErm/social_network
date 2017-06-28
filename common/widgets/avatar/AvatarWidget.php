<?php

namespace common\widgets\avatar;

use yii\base\Widget;

/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 05.04.17
 * Time: 16:37
 */
class AvatarWidget extends Widget
{
    public $user_id;

    public function run()
    {
        $user = \common\models\User::find()->where(["id"=>$this->user_id])->one();


        return $this->render('avatar', [
            'user' => $user
        ]);

    }

}