<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\WhiteIpList;

/**
 * WhiteIpListSearch represents the model behind the search form about `app\models\WhiteIpList`.
 */
class WhiteIpListSearch extends WhiteIpList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'username'], 'safe'],
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
        $query = WhiteIpList::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
