<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "characteristic_value".
 *
 * @property integer $idProduct
 * @property integer $idCharacteristic
 * @property string $value
 *
 * @property Product $idProduct0
 * @property Characteristic $idCharacteristic0
 */
class CharacteristicValueModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'characteristic_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idProduct', 'idCharacteristic', 'value'], 'required'],
            [['idProduct', 'idCharacteristic'], 'integer'],
            [['value'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idProduct' => 'Id Product',
            'idCharacteristic' => 'Id Characteristic',
            'value' => 'Value',
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
    public function getIdCharacteristic0()
    {
        return $this->hasOne(CharacteristicModel::className(), ['id' => 'idCharacteristic']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        \Yii::$app->cache->delete('product_'.$this->idProduct);
        return parent::afterSave($insert, $changedAttributes));
    }

    public function beforeDelete()
    {
        \Yii::$app->cache->delete('product_'.$this->idProduct);
        return parent::beforeDelete();
    }
}
