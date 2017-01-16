<?php

namespace andahrm\profile\controllers;

use Yii;
use yii\web\Controller;
use andahrm\person\models\Person;
use andahrm\person\models\PersonSearch;

/**
 * Default controller for the `profile` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = Person::findOne(Yii::$app->user->id);
        if ($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['index']);
//             print_r(Yii::$app->request->post());
//             return;
        }
        return $this->render('index', ['model' => $model]);
    }
}
