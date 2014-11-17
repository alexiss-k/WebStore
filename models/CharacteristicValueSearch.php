<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CharacteristicValueModel;

/**
 * CharacteristicValueSearch represents the model behind the search form about `app\models\CharacteristicValueModel`.
 */
class CharacteristicValueSearch extends CharacteristicValueModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idProduct', 'idCharacteristic'], 'integer'],
            [['value'], 'safe'],
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
        $query = CharacteristicValueModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'idProduct' => $this->idProduct,
            'idCharacteristic' => $this->idCharacteristic,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
