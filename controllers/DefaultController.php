<?php

namespace andahrm\profile\controllers;

use Yii;
use yii\web\Controller;
use andahrm\person\models\Person;
use andahrm\person\models\PersonSearch;
use andahrm\person\models\AddressContact;
use andahrm\person\models\AddressBirthPlace;
use andahrm\person\models\AddressRegister;
use andahrm\person\models\PeopleFather;
use andahrm\person\models\PeopleMother;
use andahrm\person\models\PeopleSpouse;

use andahrm\person\models\Nationality;
use andahrm\person\models\Race;
use andahrm\setting\models\LocalRegion;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `profile` module
 */
class DefaultController extends Controller
{
    public $races;
    
    public $nationalities;
    
    public $localReligions;
    /**
     * Renders the index view for the module
     * @return string
     */
    
    /*public function actionIndex()
    {
        $model = Person::findOne(Yii::$app->user->id);
        if ($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['index']);
        }
        $modelDetail = ($model->detail !== null ) ? $model->detail : new Detail(['user_id' => Yii::$app->user->id]);
        
        $this->prepareData();
        return $this->render('index', ['model' => $model, 'modelDetail' => $modelDetail]);
    }*/
    
    public function actionIndex()
    {
        $id = Yii::$app->user->id;
        $models['person'] = $this->findModel($id);
        $models['user'] = $models['person']->user;
        $models['photos'] = $models['person']->photos;
        $models['detail'] = ($models['person']->detail !== null ) ? $models['person']->detail : new Detail(['user_id' => $id]);
        $models['address-contact'] = ($models['person']->addressContact !== null ) ? $models['person']->addressContact : new AddressContact(['user_id' => $id]);
        $models['address-birth-place'] = ($models['person']->addressBirthPlace !== null ) ? $models['person']->addressBirthPlace : new AddressBirthPlace(['user_id' => $id]);
        $models['address-register'] = ($models['person']->addressRegister !== null ) ? $models['person']->addressRegister : new AddressRegister(['user_id' => $id]);
        $models['people-father'] = ($models['person']->peopleFather !== null ) ? $models['person']->peopleFather : new PeopleFather(['user_id' => $id]);
        $models['people-mother'] = ($models['person']->peopleMother !== null ) ? $models['person']->peopleMother : new PeopleMother(['user_id' => $id]);
        $models['people-spouse'] = ($models['person']->peopleSpouse !== null ) ? $models['person']->peopleSpouse : new PeopleSpouse(['user_id' => $id]);
//         $models['people-childs'] = $models['person']->peopleChilds;
        
        $post = Yii::$app->request->post();
        if($post) {
            $errorMassages = [];
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach($models as $key => $model) {
                    $model->load($post);
                    if (!$model->save()){
                        $errorMassages[] = $model->getErrors();
                    }
                }
                
                if(count($errorMassages) > 0){
                    $msg = '<ul>';
                        foreach($errorMassages as $key => $fields){
                            $msg .= '<li>'.implode("<br />", $fields).'</li>';
                        }
                    $msg .= '</ul>';
                    throw new ErrorException($msg);
                }else{
                    Yii::$app->getSession()->setFlash('saved',[
                        'type' => 'success',
                        'msg' => Yii::t('andahrm', 'Save operation completed.')
                    ]);

                    $transaction->commit();

                    return $this->redirect(['index']);
                }
            
            }catch(ErrorException $e) {
                Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'error',
                    'title' => Yii::t('andahrm', 'Unable to save record.'),
                    'msg' => $e->getMessage()
                ]);
                $transaction->rollback();
            }
        }
        
        $this->prepareData();
        
        return $this->render('index', ['models' => $models]);
    }

    /**
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function detailViewAttributes($view, $params)
    {
        extract($params);
        $dir = realpath(__DIR__.'/../views/'.$this->id);
        return require($dir.'/'.$view.'.php');
    }
    
    
    public function prepareData()
    {
        $this->races = Race::find()->all();
        
        $this->nationalities = Nationality::find()->all();
        
        $this->localReligions = LocalRegion::find()->all();
    }
}
