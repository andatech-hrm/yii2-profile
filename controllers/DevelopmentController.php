<?php

namespace andahrm\profile\controllers;



use Yii;
use andahrm\profile\models\SelfDevelopmentSearch;

class DevelopmentController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new SelfDevelopmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->sort->defaultOrder = ['development_project.start'=>SORT_DESC];

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
