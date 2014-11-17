<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "characteristic".
 *
 * @property integer $id
 * @property integer $idCategory
 * @property string $name
 * @property string $value
 *
 * @property Category $idCategory0
 * @property CharacteristicValue[] $characteristicValues
 * @property Product[] $idProducts
 */
class CharacteristicModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'characteristic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCategory', 'name', 'value'], 'required'],
            [['idCategory'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['value'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idCategory' => 'Id Category',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategory0()
    {
        return $this->hasOne(CategoryModel::className(), ['id' => 'idCategory']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristicValues()
    {
        return $this->hasMany(CharacteristicValueModel::className(), ['idCharacteristic' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducts()
    {
        return $this->hasMany(ProductModel::className(), ['id' => 'idProduct'])->viaTable('{characteristic_value}', ['idCharacteristic' => 'id']);
    }
}
