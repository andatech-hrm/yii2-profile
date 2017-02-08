<?php

namespace andahrm\profile\controllers;


use Yii;
use andahrm\positionSalary\models\PersonPositionSalary;
use andahrm\positionSalary\models\PersonPositionSalarySearch;

class PositionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new PersonPositionSalarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['user_id'=>Yii::$app->user->id]);
        $dataProvider->sort->defaultOrder = ['adjust_date'=> SORT_ASC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
