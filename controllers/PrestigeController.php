<?php

namespace andahrm\profile\controllers;

use Yii;
use andahrm\insignia\models\InsigniaPerson;
use andahrm\profile\models\SelfInsigniaPersonSearch;
use andahrm\insignia\models\InsigniaPersonSearch;

class PrestigeController extends \yii\web\Controller {

//    public function actionIndex()
//    {
//        $searchModel = new SelfInsigniaPersonSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        // $dataProvider->query->joinWith('insigniaRequest');
//        // $dataProvider->query->where(['user_id'=>Yii::$app->user->id]);
//        // $dataProvider->sort->defaultOrder = ['insignia_request.year'=> SORT_DESC];
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    public function actionIndex() {
        $searchModel = new InsigniaPersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['user_id' => Yii::$app->user->identity->id]);
        $dataProvider->sort->defaultOrder = [
            'yearly' => SORT_ASC
        ];



        //$dataProvider->sort->defaultOrder = ['development_project.start'=>SORT_DESC];

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'user_id' => $id
        ]);
    }

}
