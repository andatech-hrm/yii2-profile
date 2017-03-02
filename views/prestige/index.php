<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use andahrm\insignia\models\InsigniaRequest;
use andahrm\insignia\models\InsigniaType;

use andahrm\structure\models\PersonType;
use andahrm\structure\models\FiscalYear;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\insignia\models\InsigniaRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/insignia', 'Insignia Requests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insignia-request-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            
            [
                'attribute'=> 'insignia_request_year',
                'label'=>Yii::t('andahrm/insignia', 'Year'),
                'filter'=>FiscalYear::getList(),
                'format' => 'html',
                'value' => function($model){
                    return Html::a($model->insigniaRequest->yearTh,['/insignia/default/view','id'=>$model->insignia_request_id]);
                    }
                ],
            [
                'attribute'=> 'insignia_type_id',
                'filter'=>InsigniaType::getList(),
                'format'=>'html',
                'value' => 'insigniaType.titleIcon'
                ],
                // [
                // 'attribute'=> 'insigniaRequest.gender',
                // 'filter'=>InsigniaRequest::getGenders(),
                // 'value' => 'insigniaRequest.genderText'
                // ],
                [
                'attribute'=> 'status',
                'label'=>Yii::t('andahrm/insignia', 'Status'),
                'filter'=>InsigniaRequest::getItemStatus(),
                'value' => 'insigniaRequest.statusLabel',
                
                ],
                [
                    'content'=>function($model){
                    return Html::a(Yii::t('andahrm/insignia', 'View'),['/insignia/default/view','id'=>$model->insignia_request_id],['class'=>'btn btn-default']);
                    }
                    ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
