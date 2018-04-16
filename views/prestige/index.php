<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
####
use andahrm\insignia\models\InsigniaRequest;
use andahrm\insignia\models\InsigniaType;
use andahrm\structure\models\PersonType;
use andahrm\structure\models\FiscalYear;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\insignia\models\InsigniaRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/insignia', 'Insignia Requests');
$this->params['breadcrumbs'][] = $this->title;


/*
  $modals['position'] = Modal::begin([
  'header' => Yii::t('andahrm/structure', 'Create Position'),
  'size' => Modal::SIZE_LARGE
  ]);
  // echo $this->render('@andahrm/edoc/views/default/_form', ['model' => new \andahrm\edoc\models\Edoc(), ]);
  echo Yii::$app->runAction('/structure/position/create-ajax', ['formAction' => Url::to(['/structure/position/create-ajax'])]);
  // echo '<iframe src="" frameborder="0" style="width:100%; height: 100%;" id="iframe_edoc_create"></iframe>';

  Modal::end(); */
?>
<div class="insignia-request-index">

    <?php
    $columns = [
        'year' => [
            'attribute' => 'yearly',
            'filter' => FiscalYear::getList(),
            'value' => function($model) {
                return $model->yearTh;
            }
        ],
        'insignia_type_id' => [
            'attribute' => 'insignia_type_id',
            'filter' => InsigniaType::getList(),
            'format' => 'html',
            'value' => 'insigniaType.titleIcon',
            'noWrap' => true,
        ],
//        'status' => [
//            'attribute' => 'insigniaRequest.status',
//            'filter' => InsigniaRequest::getItemStatus(),
//            'value' => function($model) {
//                return $model->insigniaRequest->statusLabel;
//            }
//        ],
        'edoc_id' => [
            'attribute' => 'edoc_insignia_id',
            'format' => 'html',
            'value' => function($model) {
                $edoc = $model->edoc_insignia_id ? $model->edocInsignia : null;
                //$insignia = $edoc->insignia?$edoc->insignia:null;
                return $edoc ? Html::a($edoc->title, ['/edoc/insignia/view', 'id' => $model->edoc_insignia_id], ['data-pjax' => 0]) : null;
                //return $edoc->insignia;
            }
        ]
    ];

    $gridColumns = [
        ['class' => '\kartik\grid\SerialColumn'],
        $columns['year'],
        //$columns['user_id'], 
        $columns['insignia_type_id'],
        $columns['edoc_id'],
//        [
//            'class' => '\kartik\grid\ActionColumn',
//            'template' => "{delete}",
//            'buttons' => [
//                'delete' => function ($url, $model, $key) {
//                    $options = [
//                        'title' => Yii::t('andahrm', 'Delete'),
//                        'aria-label' => Yii::t('andahrm', 'Delete'),
//                        'class' => 'btnDelete',
//                        'data' => [
//                            'confirm' => Yii::t('andahrm', 'Are you sure you want to delete this item?'),
//                            'method' => 'post',
//                        ],
//                        'data-pjax' => 0,
//                    ];
//
//
//                    $url = Url::toRoute(['delete-insignia',
//                                'user_id' => $model->user_id,
//                                'insignia_type_id' => $model->insignia_type_id,
//                    ]);
//
//                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
//                }
//            ]
//        ]
    ];

    $fullExportMenu = ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $columns,
                'filename' => $this->title,
                'showConfirmAlert' => false,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'pjaxContainerId' => 'kv-pjax-container',
                'dropdownOptions' => [
                    'label' => Yii::t('andahrm', 'Full'),
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
    ]);
    ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'id' => 'data-grid',
        'pjax' => true,
//        'resizableColumns'=>true,
//        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
//        'floatHeader'=>true,
//        'floatHeaderOptions'=>['scrollingTop'=>'50'],
        'export' => [
            'label' => Yii::t('andahrm', 'Page'),
            'fontAwesome' => true,
            'target' => GridView::TARGET_SELF,
            'showConfirmAlert' => false,
        ],
//         'exportConfig' => [
//             GridView::HTML=>['filename' => $exportFilename],
//             GridView::CSV=>['filename' => $exportFilename],
//             GridView::TEXT=>['filename' => $exportFilename],
//             GridView::EXCEL=>['filename' => $exportFilename],
//             GridView::PDF=>['filename' => $exportFilename],
//             GridView::JSON=>['filename' => $exportFilename],
//         ],
        'panel' => [
            //'heading'=>'<h3 class="panel-title"><i class="fa fa-th"></i> '.Html::encode($this->title).'</h3>',
//             'type'=>'primary',
            'before' => '',
            'heading' => false,
        //'footer'=>false,
        ],
        'toolbar' => [
            '{export}',
            '{toggleData}',
            $fullExportMenu,
        ],
        'columns' => $gridColumns,
    ]);
    ?>

</div>