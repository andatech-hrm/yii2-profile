<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

use yii\widgets\Pjax;
use yii\helpers\Url;
use andahrm\development\models\DevelopmentPerson;
use andahrm\development\models\DevelopmentProject;
use andahrm\development\models\DevelopmentActivityChar;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\development\models\DevelopmentPersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'การจัดการงานพัฒนาบุคลากร');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="development-person-index">    
 



<?php
$columns = [
    'dev_activity_char_id' =>  [
                    'attribute' => 'dev_activity_char_id',
                    'filter' => DevelopmentActivityChar::getList(),
                    'value' => 'devChar.title',
                    'contentOptions' => ['nowrap' => 'nowrap']
                ],
  'dev_project_id' => [
                    'attribute' => 'dev_project_id',
                    'value' => 'devProject.titlePlace',
                    'format' => 'html',
                    'filter' => DevelopmentProject::getList(),
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                        'options' => ['id' => 'filter_dev_project_id']
                    ],
                    'filterInputOptions' => ['placeholder' => 'ค้นหาโครงการ'],
                ],
     
     'rangeDate'=>[
                    'attribute' => 'rangeDate',
                    //'filter' => DevelopmentActivityChar::getList(),
                    'filterType' => GridView::FILTER_DATE_RANGE,
                    'filterWidgetOptions' => [
                        'language' => Yii::$app->language,
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'format' => 'html',
                    'value' => 'rangeDate',
                    'contentOptions' => ['nowrap' => 'nowrap']
                ],
];

$gridColumns = [
   ['class' => '\kartik\grid\SerialColumn'],
    $columns['dev_project_id'],
    $columns['dev_activity_char_id'],
    $columns['rangeDate'],
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
        'label' => 'Full',
        'class' => 'btn btn-default',
        'itemsBefore' => [
            '<li class="dropdown-header">Export All Data</li>',
        ],
    ],
]);
?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'data-grid',
        'pjax'=>true,
//        'resizableColumns'=>true,
//        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
//        'floatHeader'=>true,
//        'floatHeaderOptions'=>['scrollingTop'=>'50'],
        'export' => [
            'label' => Yii::t('yii', 'Page'),
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
            'before'=> false,
                'heading'=>false,
                //'footer'=>false,
        ],
        'toolbar' => [
            '{export}',
            '{toggleData}',
            $fullExportMenu,
        ],
        'columns' => $gridColumns,
    ]); ?>
</div>
<?php
$js[] = "
$(document).on('click', '#btn-reload-grid', function(e){
    e.preventDefault();
    $.pjax.reload({container: '#data-grid-pjax'});
});
";

$this->registerJs(implode("\n", $js));
