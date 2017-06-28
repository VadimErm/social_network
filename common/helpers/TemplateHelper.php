<?php
namespace common\helpers;

use yii\helpers\Html;

class TemplateHelper
{
    /**
     * Method for render template
     * @param $view yii\web\View
     * @param array $params
     * @param null $context
     * @return string
     */
    public static function deliver($view, $id, $template, $params = [], $context = null)
    {
        return Html::tag('template',
            $view->render($template, $params, $context),
            [
                'id' => $id,
                'style' => 'display: none;'
            ]
        );
    }
}