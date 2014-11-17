<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "price_history".
 *
 * @property integer $id
 * @property integer $idProduct
 * @property string $price
 * @property string $date
 *
 * @property Product $idProduct0
 */
class PriceHistoryModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'price_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idProduct', 'price', 'date'], 'required'],
            [['idProduct'], 'integer'],
            [['price'], 'number'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idProduct' => 'Id Product',
            'price' => 'Price',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduct0()
    {
        return $this->hasOne(ProductModel::className(), ['id' => 'idProduct']);
    }
}
