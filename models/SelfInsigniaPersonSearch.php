<?php

namespace andahrm\profile\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\insignia\models\InsigniaPerson;
use andahrm\insignia\models\InsigniaPersonSearch;

/**
 * InsigniaPersonSearch represents the model behind the search form of `andahrm\insignia\models\InsigniaPerson`.
 */
class SelfInsigniaPersonSearch extends InsigniaPersonSearch
{
       

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
            'insignia_type_id' => $this->insignia_type_id,
            'yearly' => $this->yearly,
            'salary' => $this->salary,
            'position_id' => $this->position_id,
            'edoc_insignia_id' => $this->edoc_insignia_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'feat', $this->feat])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
