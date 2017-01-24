<?php
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use andahrm\person\models\Person;
use andahrm\person\models\PersonSearch;
use andahrm\setting\models\Helper;

use andahrm\person\PersonApi;
?>
<?php
$user = Yii::$app->user->identity;
$profile = $user->profile;
// $person = Person::findOne($user->id);
$person = PersonApi::instance($user->id);
$module = $this->context->module->id;
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<div class="x_panel">
    <div class="x_title">
        <h2>User Report <small>Activity report</small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

            <div class="profile_img">

                <!-- end of image cropping -->
                <div id="crop-avatar">
                    <!-- Current avatar -->
                    <img class="img-responsive avatar-view" src="<?= $person->getPhotoLast(); ?>" alt="Avatar" title="Change the avatar">
                    <!-- Loading state -->
                    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                </div>
                <!-- end of image cropping -->

            </div>
            <h3><?= $person->getFullname(); ?></h3>

            <ul class="list-unstyled user_data">
                <li>
                    <i class="fa fa-map-marker user-profile-icon"></i>
                    <?= $person->getAddress(); ?>
                </li>

                <li>
                    <i class="fa fa-briefcase user-profile-icon"></i>
                    <?=$person->getPosition(); ?>
                </li>
                <li>
                    <i class="fa fa-briefcase user-profile-icon"></i>
                    <?=$person->getSection(); ?>
                </li>
            </ul>

            <!-- <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a> -->

        </div>
        <div class="col-md-9 col-sm-9 col-xs-12">

            <div class="profile_title">
                <div class="col-md-6">
                    <h2>User Activity Report</h2>
                </div>
                <div class="col-md-6">
                    <div id="reportrange" class="pull-right" style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>December 17, 2016 - January 15, 2017</span> <b class="caret"></b>
                    </div>
                </div>
            </div>
            
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <?php
            $request = Yii::$app->request;
            $menuItems = [];
                $menuItems = [
                    [
                        'label' => '<i class="fa fa-history"></i> ' . Yii::t('andahrm/person', 'Default'),
                        'url' => Helper::urlParams("/{$module}/default"),
                    ],                    
                    [
                        'label' => '<i class="fa fa-info-circle"></i>  ' . Yii::t('andahrm/person', 'Detail'),
                        'url' => Helper::urlParams("/{$module}/detail"),
                    ],
                    [
                        'label' => '<i class="fa fa-camera"></i>  ' . Yii::t('andahrm/person', 'Photo'),
                        'url' => Helper::urlParams("/{$module}/photo"),
                    ], 
                    [
                        'label' => '<i class="fa fa-camera"></i>  ' . Yii::t('andahrm/person', 'Position'),
                        'url' => Helper::urlParams("/{$module}/position"),
                    ], 
                    [
                        'label' => '<i class="fa fa-child"></i>  ' . Yii::t('andahrm/person', 'Child'),
                        'url' => Helper::urlParams("/{$module}/child"),
                    ], 
                ];
            echo Menu::widget([
                'options' => ['class' => 'nav nav-tabs bar_tabs'],
                'encodeLabels' => false,
                'items' => $menuItems,
            ]);
            ?>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active in" aria-labelledby="profile-tab">
                        <?= $content; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>
