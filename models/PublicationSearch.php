<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Publication;

/**
 * PublicationSearch represents the model behind the search form about `app\models\Publication`.
 */
class PublicationSearch extends Publication
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'categorie_id'], 'integer'],
            [['reference', 'auteurs', 'titre', 'date', 'journal', 'volume', 'number', 'pages', 'note', 'abstract', 'keywords', 'series', 'localite', 'publisher', 'editor', 'pdf', 'date_display'], 'safe'],
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
        $query = Publication::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'date' => $this->date,
            'categorie_id' => $this->categorie_id,
        ]);

        $query->andFilterWhere(['like', 'reference', $this->reference])
            ->andFilterWhere(['like', 'auteurs', $this->auteurs])
            ->andFilterWhere(['like', 'titre', $this->titre])
            ->andFilterWhere(['like', 'journal', $this->journal])
            ->andFilterWhere(['like', 'volume', $this->volume])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'pages', $this->pages])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'abstract', $this->abstract])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'series', $this->series])
            ->andFilterWhere(['like', 'localite', $this->localite])
            ->andFilterWhere(['like', 'publisher', $this->publisher])
            ->andFilterWhere(['like', 'editor', $this->editor])
            ->andFilterWhere(['like', 'pdf', $this->pdf])
            ->andFilterWhere(['like', 'date_display', $this->date_display]);

        return $dataProvider;
    }
}
