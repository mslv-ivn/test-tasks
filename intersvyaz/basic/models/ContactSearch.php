<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contact;

/**
 * ContactSearch represents the model behind the search form of `app\models\Contact`.
 */
class ContactSearch extends Contact
{
    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['group.name', 'search_field']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), ['search_field' => 'Поле поиска']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'group_id'], 'integer'],
            [['phone_number', 'name', 'group.name', 'search_field'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Contact::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // join with relation `group` that is a relation to the table `contact`
        // and set the table alias to be `group`
        $query->joinWith('group AS group');
        // enable sorting for the related column
        $dataProvider->sort->attributes['group.name'] = [
            'asc' => ['group.name' => SORT_ASC],
            'desc' => ['group.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'contact.user_id' => \Yii::$app->user->id,
            'group_id' => $this->group_id,
        ]);

//        $query->andFilterWhere(['like', 'phone_number', $this->phone_number])
//            ->andFilterWhere(['like', 'contact.name', $this->name])
//            ->andFilterWhere(['like', 'group.name', $this->getAttribute('group.name')]);

        $query->andFilterWhere(['or',
            ['like', 'phone_number', $this->search_field],
            ['like', 'contact.name', $this->search_field],
            ['like', 'group.name', $this->search_field]]);

        return $dataProvider;
    }
}
