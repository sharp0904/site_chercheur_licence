<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Categorie;

/**
 * CategorieSearch represents the model behind the search form about `app\models\Categorie`.
 */
class CategorieSearch extends Categorie
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'integer'],
            [['name_fr', 'name_en'], 'safe'],
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
        $query = Categorie::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
        ]);

        $query->andFilterWhere(['like', 'name_fr', $this->name_fr])
            ->andFilterWhere(['like', 'name_en', $this->name_en]);

        return $dataProvider;
    }
}
