<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrderModel;

/**
 * OrderSearch represents the model behind the search form about `app\models\OrderModel`.
 */
class OrderSearch extends OrderModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idUser', 'idPayment', 'idShipping', 'paymentStatus'], 'integer'],
            [['totalPrice'], 'number'],
            [['date'], 'safe'],
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
        $query = OrderModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idUser' => $this->idUser,
            'totalPrice' => $this->totalPrice,
            'date' => $this->date,
            'idPayment' => $this->idPayment,
            'idShipping' => $this->idShipping,
            'paymentStatus' => $this->paymentStatus,
        ]);

        return $dataProvider;
    }
}
