<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ActivityParticipant;

/**
 * app\models\ActivityParticipantSearch represents the model behind the search form about `app\models\ActivityParticipant`.
 */
 class ActivityParticipantSearch extends ActivityParticipant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'task_participant_id', 'activity_id', 'hours_worked'], 'integer'],
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
        $query = ActivityParticipant::find();

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
            'task_participant_id' => $this->task_participant_id,
            'activity_id' => $this->activity_id,
            'hours_worked' => $this->hours_worked,
        ]);

        return $dataProvider;
    }
}
