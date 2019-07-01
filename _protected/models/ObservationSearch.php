<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Observation;

/**
 * app\models\ObservationSearch represents the model behind the search form about `app\models\Observation`.
 */
 class ObservationSearch extends Observation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'supervisor_id', 'project_id'], 'integer'],
            [['comment', 'file', 'timestamp'], 'safe'],
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
        $query = Observation::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'supervisor_id' => $this->supervisor_id,
            'project_id' => $this->project_id,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }
}
