<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_list".
 *
 * @property integer $idOrder
 * @property integer $idProduct
 * @property integer $quantity
 * @property string $price
 * @property string $productName
 *
 * @property Product $idProduct0
 * @property Order $idOrder0
 */
class ProductListModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idOrder', 'idProduct', 'quantity', 'price', 'productName'], 'required'],
            [['idOrder', 'idProduct', 'quantity'], 'integer'],
            [['price'], 'number'],
            [['productName'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idOrder' => 'Id Order',
            'idProduct' => 'Id Product',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'productName' => 'Product Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduct0()
    {
        return $this->hasOne(ProductModel::className(), ['id' => 'idProduct']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOrder0()
    {
        return $this->hasOne(OrderModel::className(), ['id' => 'idOrder']);
    }
}
