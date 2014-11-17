<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shipping".
 *
 * @property integer $id
 * @property string $name
 * @property string $systemName
 * @property string $description
 *
 * @property Order[] $orders
 */
class ShippingModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shipping';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'systemName', 'description'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['systemName'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 600]
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
            'systemName' => 'System Name',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(OrderModel::className(), ['idShipping' => 'id']);
    }
}
