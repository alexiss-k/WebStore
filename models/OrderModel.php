<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $idUser
 * @property string $totalPrice
 * @property string $date
 * @property integer $idPayment
 * @property integer $idShipping
 * @property integer $paymentStatus
 *
 * @property User $idUser0
 * @property Payment $idPayment0
 * @property Shipping $idShipping0
 * @property ProductList[] $productLists
 * @property Product[] $idProducts
 */
class OrderModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idUser', 'totalPrice', 'date', 'idPayment', 'idShipping', 'paymentStatus'], 'required'],
            [['idUser', 'idPayment', 'idShipping', 'paymentStatus'], 'integer'],
            [['totalPrice'], 'number'],
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
            'idUser' => 'Id User',
            'totalPrice' => 'Total Price',
            'date' => 'Date',
            'idPayment' => 'Id Payment',
            'idShipping' => 'Id Shipping',
            'paymentStatus' => 'Payment Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser0()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'idUser']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPayment0()
    {
        return $this->hasOne(PaymentModel::className(), ['id' => 'idPayment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdShipping0()
    {
        return $this->hasOne(ShippingModel::className(), ['id' => 'idShipping']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductLists()
    {
        return $this->hasMany(ProductListModel::className(), ['idOrder' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducts()
    {
        return $this->hasMany(ProductModel::className(), ['id' => 'idProduct'])->viaTable('{product_list}', ['idOrder' => 'id']);
    }
}
