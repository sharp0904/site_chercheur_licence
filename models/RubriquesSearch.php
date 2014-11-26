<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use app\models\Rubrique;

/**
 * RubriquesSearch represents the model behind the search form about `app\models\Rubrique`.
 */
class RubriquesSearch extends Rubrique
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'menu_id'], 'integer'],
            [['date_creation', 'date_modification', 'content_fr', 'content_en'], 'safe'],
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
    public function search($params)
    {
        $query = Rubrique::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => RubriquesSearch::pagination(),
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date_creation' => $this->date_creation,
            'date_modification' => $this->date_modification,
            'menu_id' => $this->menu_id,
        ]);

        $query->andFilterWhere(['like', 'content_fr', $this->content_fr])
            ->andFilterWhere(['like', 'content_en', $this->content_en]);

        return $dataProvider;
    }
    
    public function pagination()
    {
		$query = Rubrique::find();
        
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
        
        return $pagination;
	}
}
