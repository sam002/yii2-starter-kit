<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lav45\translate\models\Lang;

/**
 * LangSearch represents the model behind the search form about `lav45\translate\models\Lang`.
 */
class LangSearch extends Lang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'locale', 'name'], 'safe'],
            [['status'], 'integer'],
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
        $query = Lang::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'locale', $this->locale])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
