<?php

namespace andahrm\profile;

use Yii;
/**
 * profile module definition class
 */
class Module extends \yii\base\Module
{
    public $layout = '@andahrm/profile/views/layouts/main';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'andahrm\profile\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (Yii::$app->user->isGuest) {
            throw new \yii\web\ForbiddenHttpException();
        }
        parent::init();

        // custom initialization code goes here
    }
}
