<?php

namespace andahrm\profile\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\insignia\models\InsigniaPerson;

/**
 * InsigniaPersonSearch represents the model behind the search form of `andahrm\insignia\models\InsigniaPerson`.
 */
class SelfInsigniaPersonSearch extends InsigniaPerson
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['insignia_request_id', 'user_id', 'last_position_id', 'last_edoc_id', 'last_insignia_request_id', 'insignia_type_id'], 'integer'],
            [['last_step', 'last_salary'], 'number'],
            [['last_adjust_date', 'feat', 'note','insignia_request_year'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
     public $insignia_request_year;
     
    public function search($params)
    {
        $query = InsigniaPerson::find();

        // add conditions that should always apply here
        $query->joinWith('insigniaRequest');

        $query->where(['user_id'=>Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'insignia_request_year'=>SORT_DESC,
                    ]
            ]
        ]);
        
        $dataProvider->sort->attributes['insignia_request_year'] = [
        // The tables are the ones our relation are configured to
        // in my case they are prefixed with "tbl_"
        'asc' => ['insignia_request.year' => SORT_ASC],
        'desc' => ['insignia_request.year' => SORT_DESC],
    ];
        
       

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'insignia_request_id' => $this->insignia_request_id,
            'user_id' => $this->user_id,
            'last_step' => $this->last_step,
            'last_adjust_date' => $this->last_adjust_date,
            'last_salary' => $this->last_salary,
            'last_position_id' => $this->last_position_id,
            'last_edoc_id' => $this->last_edoc_id,
            'last_insignia_request_id' => $this->last_insignia_request_id,
            'insignia_type_id' => $this->insignia_type_id,
        ]);

        $query->andFilterWhere(['like', 'feat', $this->feat])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
