<?php
use kartik\detail\DetailView;
use andahrm\person\models\Title;
use yii\helpers\ArrayHelper;
use andahrm\setting\models\WidgetSettings;
?>
<div class="profile-default-index">
    <?php
    echo DetailView::widget([
        'model'=>$model,
        'vAlign' => DetailView::ALIGN_TOP,
        'panel'=>[
            'heading'=>'Post # ' . $model->fullname,
            'type'=>DetailView::TYPE_INFO,
        ],
        
        'attributes'=>[
            [
                'attribute'=>'user_id',
                'format'=>'raw',
                'value'=>'<kbd>'.$model->user_id.'</kbd>',
                'displayOnly'=>true
            ],[
                'attribute' => 'fullname',
                'value' => $model->getFullname('th'),
                'updateMarkup' => function($form, $widget) {
                $model = $widget->model;
                return '<div class="row">'.$form->field($model, 'title_id', ['options' => ['class' => 'form-group col-sm-2']])->dropDownList(ArrayHelper::map(Title::find()->all(), 'id', 'name')) . ' ' . 
                    $form->field($model, 'firstname_th', ['options' => ['class' => 'form-group col-sm-5']]) . ' ' .
                    $form->field($model, 'lastname_th', ['options' => ['class' => 'form-group col-sm-5']]) . '</div>';
                }
            ],[
                'attribute' => 'fullname',
                'value' => $model->getFullname('en'),
                'updateMarkup' => function($form, $widget) {
                $model = $widget->model;
                return '<div class="row">'.$form->field($model, 'title_id', ['options' => ['class' => 'form-group col-sm-2']])->dropDownList(ArrayHelper::map(Title::find()->all(), 'id', 'name')) . ' ' . 
                    $form->field($model, 'firstname_en', ['options' => ['class' => 'form-group col-sm-5']]) . ' ' .
                    $form->field($model, 'lastname_en', ['options' => ['class' => 'form-group col-sm-5']]) . '</div>';
                }
            ],[
                'attribute' => 'gender',
                'type' => DetailView::INPUT_RADIO_LIST,
                'items' => $model->getGenders(),
            ],[
                'attribute' => 'tel',
            ],[
                'attribute' => 'phone',
            ],[
                'attribute' => 'birthday',
                'type'=>DetailView::INPUT_DATE,
                'widgetOptions' => WidgetSettings::DatePicker()
            ]
        ],
    ]);
    ?>
</div>
