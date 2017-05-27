<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Art;

/**
 * ArtSearch represents the model behind the search form about `app\models\Art`.
 */
class ArtSearch extends Art
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'calid', 'cityid', 'price_min', 'price_max', 'status'], 'integer'],
            [['name', 'openid', 'poster', 'show_time', 'address', 'summary', 'group_code', 'price_link', 'ext_content', 'ext_link', 'create_time'], 'safe'],
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
        $query = Art::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'calid' => $this->calid,
            'show_time' => $this->show_time,
            'cityid' => $this->cityid,
            'price_min' => $this->price_min,
            'price_max' => $this->price_max,
            'status' => $this->status,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'openid', $this->openid])
            ->andFilterWhere(['like', 'poster', $this->poster])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'group_code', $this->group_code])
            ->andFilterWhere(['like', 'price_link', $this->price_link])
            ->andFilterWhere(['like', 'ext_content', $this->ext_content])
            ->andFilterWhere(['like', 'ext_link', $this->ext_link]);

        return $dataProvider;
    }
}
