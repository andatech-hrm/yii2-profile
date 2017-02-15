<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use andahrm\setting\widgets\XPanel;
?>
<div class="row">
    <div class="col-sm-6 animated flipInY">
        <?php
        $mkey = 'person';
        XPanel::begin(['header' => 'Basic',]);

        $fields = [
            'citizen_id' => $models[$mkey]->citizen_id,
            'title_id' => $models[$mkey]->title->name,
            'fullname_th' => $models[$mkey]->fullname,
            'fullname_en' => $models[$mkey]->getFullname('en'),
            'gender' => $models[$mkey]->getGenderText(),
            'tel' => $models[$mkey]->tel,
            'phone' => $models[$mkey]->phone,
            'birthday' => $models[$mkey]->birthday,
        ];
        ?>
        <table class="table detail-view">
            <tbody>
                <?php foreach ($fields as $key => $value) : ?>
                <tr>
                    <th><?= $models[$mkey]->getAttributeLabel($key); ?></th>
                    <td class="green"><?= $value; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php XPanel::end() ?>
            
    </div>
        
    <div class="col-sm-6 set-height-as-left animated flipInY">
        <?php
        $mkey = 'detail';
        XPanel::begin(['header' => 'Detail',]);
        
        $fields = [
            'nationality_id' => $models[$mkey]->nationality->title,
            'race_id' => $models[$mkey]->race->title,
            'religion_id' => $models[$mkey]->religion->title,
            'blood_group' => $models[$mkey]->blood_group,
            'married_status' => $models[$mkey]->getStatusText(),
        ];
        ?>
        <table class="table detail-view">
            <tbody>
            <?php foreach ($fields as $key => $value) : ?>
            <tr>
                <th><?= $models[$mkey]->getAttributeLabel($key); ?></th>
                <td class="green"><?= $value; ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php XPanel::end() ?>
        
        <?php if(intval($models['detail']->married_status) !== \andahrm\person\models\Detail::STATUS_SINGLE) : ?>
        <?php
        $mkey = 'people-spouse';
        XPanel::begin(['header' => 'Spouse',]);
        
        $fields = [
            'citizen_id' => $models[$mkey]->citizen_id,
            'fullname' => $models[$mkey]->fullname,
            'birthday' => $models[$mkey]->birthday,
            'nationality_id' => $models[$mkey]->nationality->title,
            'race_id' => $models[$mkey]->race->title,
            'occupation' => $models[$mkey]->occupation,
            'live_status' => $models[$mkey]->liveStatusText,
        ];
        ?>
        <table class="table detail-view">
            <tbody>
            <?php foreach ($fields as $key => $value) : ?>
            <tr>
                <th><?= $models[$mkey]->getAttributeLabel($key); ?></th>
                <td class="green"><?= $value; ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php XPanel::end(); ?>
        <?php endif; ?>
        
    </div>
</div>


<div class="row">
    <?php
     $modalPreview = Modal::begin([
    'header' => '<h4 class="modal-title">Preview</h4>',
    ]);
            
    echo 'Loading...';
    
    Modal::end();
    
    $js[] = <<< JS
$("#{$modalPreview->id}").on("show.bs.modal", function (e) { $(".modal-body").html("<img src=\""+e.relatedTarget+"\">"); });
JS;
    ?>
    <div class="col-sm-12">
    <?php
    $mkey = 'photos';
    XPanel::begin(['header' => 'Photo',]);
    ?>
    <div class="row">
    <?php foreach($models[$mkey] as $key => $photo) : ?>
    <div class="col-sm-3">
        <div class="thumbnail">
            <div class="image view view-first">
                <?= Html::img($photo->getUploadUrl('image_cropped'), ['style' => 'width: 100%; display: block;', 'alt' => 'image']); ?>
                <div class="mask">
                    <p><?= $photo->year; ?></p>
                    <div class="tools tools-bottom">
                        <?php
                        echo Html::a('<i class="fa fa-eye"></i>', $photo->getUploadUrl('image_cropped'), [
                            'title' => Yii::t('andahrm', 'View'),
                            'data-toggle' => 'modal',
                            'data-target' => "#{$modalPreview->id}"
                        ]);
                        
                        echo Html::a('<i class="fa fa-picture-o"></i>', $photo->getUploadUrl('image'), [
                            'title' => Yii::t('andahrm', 'Original'),
                            'target' => '_blank',
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="caption text-center">
                <h3><?= $photo->year; ?></h3>
            </div>
        </div>
    </div>

    <?php endforeach; ?>
    </div>
    
    <?php XPanel::end() ?>
    </div>
</div>




<div class="row">
    <div class="col-sm-12">
        <?php
        $addresses = [
            ['key' => 'address-contact', 'label' => Yii::t('andahrm/person', 'Contact')],
            ['key' => 'address-register', 'label' => Yii::t('andahrm/person', 'Register')],
            ['key' => 'address-birth-place', 'label' => Yii::t('andahrm/person', 'Birth Place')],
        ];
        $items = [];
        foreach ($addresses as $key => $address) {
            $items[] = $models[$address['key']];
        }
        
        XPanel::begin(['header' => 'Address',]);
        
        echo \yii\grid\GridView::widget([
            'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $items]),
            'summary'=>false,
            'columns' => [
                [
                    'label' => Yii::t('andahrm', 'Type'),
                    'value' => function($model, $index) use ($addresses){
                        return ucfirst($addresses[$index]['label']);
                    }
                ],
                //'number_registration',
                [
                    'attribute' => 'addressText',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'postcode',
                    'contentOptions' => ['class' => 'green'],
                ],
                //'phone',
                //'fax',
                [
                    'attribute' => 'move_in_date',
                    'contentOptions' => ['class' => 'green'],
                ],
                //'move_out_date',
            ],
        ]);
        ?>
        <?php XPanel::end(); ?>
    </div>
</div>



<div class="row">
    <div class="col-sm-12">
        <?php
        $parents = [
            ['key' => 'people-father', 'label' => Yii::t('andahrm/person', 'Father')],
            ['key' => 'people-mother', 'label' => Yii::t('andahrm/person', 'Mother')],
        ];
        $items = [];
        foreach ($parents as $key => $parent) {
            $items[] = $models[$parent['key']];
        }
        
        XPanel::begin(['header' => 'Parents',]);
                    
        echo \yii\grid\GridView::widget([
            'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $items]),
            'summary'=>false,
            'columns' => [
                [
                    'label' => Yii::t('andahrm', 'Type'),
                    'value' => function($model, $index) use ($parents){
                        return ucfirst($parents[$index]['label']);
                    }
                ],
                [
                    'attribute' => 'citizen_id',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'fullname',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'birthday',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'nationality.title',
                    'label' => Yii::t('andahrm/person', 'Nationality'),
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'race.title',
                    'label' => Yii::t('andahrm/person', 'Race'),
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'occupation',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'liveStatusText',
                    'label' => Yii::t('andahrm/person', 'Live Status Text'),
                    'contentOptions' => ['class' => 'green'],
                ],
            ],
        ]);
        ?>
        <?php XPanel::end(); ?>
    </div>
</div>




<div class="row">
    <div class="col-sm-12">
        <?php
        XPanel::begin(['header' => 'Childs',]);
        
        $mkey = 'people-childs';
                    
        $childDataProvider = new \yii\data\ActiveDataProvider([
            'query' => $models['person']->getPeopleChilds(),
        ]);

        echo \yii\grid\GridView::widget([
            'dataProvider' => $childDataProvider,
            'summary'=>false,
            'columns' => [
                [
                    'attribute' => 'citizen_id',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'fullname',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'birthday',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'nationality.title',
                    'label' => Yii::t('andahrm/person', 'Nationality'),
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'race.title',
                    'label' => Yii::t('andahrm/person', 'Race'),
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'occupation',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'liveStatusText',
                    'label' => Yii::t('andahrm/person', 'Live Status Text'),
                    'contentOptions' => ['class' => 'green'],
                ],
            ],
        ]);
        ?>
        <?php XPanel::end(); ?>
    </div>
</div><!-- end row -->




<div class="row">
    <div class="col-sm-12">
        <?php
        $mkey = 'educations';
        XPanel::begin(['header' => 'Educations',]);
                    
        $educationDataProvider = new \yii\data\ActiveDataProvider([
            'query' => $models['person']->getEducations(),
        ]);
        
        echo \yii\grid\GridView::widget([
            'dataProvider' => $educationDataProvider,
            'summary'=>false,
            'columns' => [
                [
                    'attribute' => 'year_start',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'year_end',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'level.title',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'degree',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'branch',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'institution',
                    'contentOptions' => ['class' => 'green'],
                ],
                [
                    'attribute' => 'country.title',
                    'contentOptions' => ['class' => 'green'],
                ],
            ],
        ]);
        
        XPanel::end(); 
        ?>
    </div>
</div><!-- end row -->
            
            
            
            
            



<?php $this->registerJs(implode("\n", $js)); ?>


<?php
$this->registerCss("
table.table.detail-view{
    margin: 0;
}
table.table.detail-view th,
table.table.detail-view td{
    border: 0;
}
.panel_toolbox{
    min-width: initial;
}
.panel_toolbox>li>a{
    color: #5A738E;
}");
?>