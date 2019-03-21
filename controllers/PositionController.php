<?php

namespace andahrm\profile\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use andahrm\positionSalary\models\PersonPositionSalary;
use andahrm\positionSalary\models\PersonPositionSalarySearch;
use andahrm\positionSalary\models\PersonPositionSalaryOld;

class PositionController extends \yii\web\Controller {

    public function actionIndex() {
//        $searchModel = new PersonPositionSalarySearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->query->where(['user_id' => Yii::$app->user->id]);
//        $dataProvider->sort->defaultOrder = ['adjust_date' => SORT_ASC];
//        return $this->render('index', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);


        $modelPositionOld = PersonPositionSalaryOld::find()->where(['user_id' => $id])
                ->joinWith('edoc')
                //->orderBy(['adjust_date'=> SORT_ASC,'edoc.date_code'=>SORT_ASC,'edoc.code'=> SORT_ASC])
                ->orderBy([
                    //'adjust_date'=> SORT_ASC,
                    'edoc.date_code' => SORT_ASC,
                    'edoc.code' => SORT_ASC
                ])
                ->all();
        $modelPosition = PersonPositionSalary::find()->where(['user_id' => $id])
                ->joinWith('edoc')
                //->orderBy(['adjust_date'=> SORT_ASC,'edoc.date_code'=>SORT_ASC,'edoc.code'=> SORT_ASC])
                ->orderBy([
                    //'adjust_date'=> SORT_ASC,
                    'edoc.date_code' => SORT_ASC,
                    'edoc.code' => SORT_ASC
                ])
                ->all();

        $data = ArrayHelper::merge($modelPositionOld, $modelPosition);
        //$data = $modelPosition;
        //$data = ArrayHelper::multisort($data, ['adjust_date'], [SORT_ASC]);
        //print_r($data);
        //exit();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false,
            'sort' => [
                'attributes' => ['adjust_date' => SORT_ASC],
            ],
        ]);
        
        return $this->render('view-position', [
                    'models' => $models,
                    'newModelEdoc' => $newModelEdoc,
                    //'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);

        
    }

}
