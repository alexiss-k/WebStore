<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $price
 * @property integer $quantity
 * @property integer $isAvailable
 * @property string $photo
 * @property string $rating
 * @property integer $amountRated
 * @property integer $idCategory
 *
 * @property CharacteristicValue[] $characteristicValues
 * @property Characteristic[] $idCharacteristics
 * @property Comment[] $comments
 * @property PriceHistory[] $priceHistories
 * @property ProductList[] $productLists
 * @property Order[] $idOrders
 */
class ProductModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'price', 'quantity', 'isAvailable', 'rating', 'amountRated', 'idCategory'], 'required'],
            [['description'], 'string'],
            [['price', 'rating'], 'number'],
            [['quantity', 'isAvailable', 'amountRated', 'idCategory'], 'integer'],
            [['name', 'photo'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'isAvailable' => 'Is Available',
            'photo' => 'Photo',
            'rating' => 'Rating',
            'amountRated' => 'Amount Rated',
            'idCategory' => 'Id Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristicValues()
    {
        return $this->hasMany(CharacteristicValueModel::className(), ['idProduct' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCharacteristics()
    {
        return $this->hasMany(CharacteristicModel::className(), ['id' => 'idCharacteristic'])->viaTable('{characteristic_value}', ['idProduct' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(CommentModel::className(), ['idProduct' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriceHistories()
    {
        return $this->hasMany(PriceHistoryModel::className(), ['idProduct' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductLists()
    {
        return $this->hasMany(ProductListModel::className(), ['idProduct' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOrders()
    {
        return $this->hasMany(OrderModel::className(), ['id' => 'idOrder'])->viaTable('{product_list}', ['idProduct' => 'id']);
    }
}
