<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parentId
 *
 * @property Characteristic[] $characteristics
 */
class CategoryModel extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parentId'], 'integer'],
            [['name'], 'string', 'max' => 255]
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
            'parentId' => 'Parent ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristics()
    {
        return $this->hasMany(CharacteristicModel::className(), ['idCategory' => 'id']);
    }

    /**
     * @return \app\models\CategoryModel
     */
    public static function getCategoryById($id)
    {
        $categories = \Yii::$app->cache->get('categories');
        if ($categories === false) {
            $categories = CategoryModel::find()->all();
            \Yii::$app->cache->add('categories',$categories);
        }

        foreach($categories as $category)
        {
            if ($category->id == $id)
                return $category;
        }

        return null;
    }

    /**
     * @return array \app\models\CategoryModel
     */
    public static function getCategoriesByParentId($parentId)
    {
        $categories = \Yii::$app->cache->get('categories');
        if ($categories === false) {
            $categories = CategoryModel::find()->all();
            \Yii::$app->cache->add('categories',$categories);
        }

        $result_categories = array();

        foreach($categories as $category)
        {
            if ($category->parentId == $parentId)
                $result_categories[] = $category;
        }

        return $result_categories;
    }

    public function afterSave($insert, $changedAttributes)
    {
        \Yii::$app->cache->delete('categories');
        if (parent::afterSave($insert, $changedAttributes)) {
            
            return true;
        } else {
            return false;
        }
    }

    public function beforeDelete()
    {
        \Yii::$app->cache->delete('categories');
        if (parent::beforeDelete()) {
            
            return true;
        } else {
            return false;
        }
    }
}
