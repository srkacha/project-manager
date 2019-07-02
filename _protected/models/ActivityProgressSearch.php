<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ActivityProgress;

/**
 * app\models\ActivityProgressSearch represents the model behind the search form about `app\models\ActivityProgress`.
 */
 class ActivityProgressSearch extends ActivityProgress
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activity_participant', 'hours_done'], 'integer'],
            [['timestamp', 'comment'], 'safe'],
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
        $query = ActivityProgress::find();

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
            'timestamp' => $this->timestamp,
            'activity_participant' => $this->activity_participant,
            'hours_done' => $this->hours_done,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
