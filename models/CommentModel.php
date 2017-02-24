<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $idUser
 * @property integer $idProduct
 * @property string $text
 * @property string $date
 * @property integer $mark
 *
 * @property User $idUser0
 * @property Product $idProduct0
 */
class CommentModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idUser', 'idProduct', 'text', 'date', 'mark'], 'required'],
            [['idUser', 'idProduct', 'mark'], 'integer'],
            [['date'], 'safe'],
            [['text'], 'string', 'max' => 600]
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
            'idProduct' => 'Id Product',
            'text' => 'Text',
            'date' => 'Date',
            'mark' => 'Mark'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'idUser']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduct0()
    {
        return $this->hasOne(ProductModel::className(), ['id' => 'idProduct']);
    }

    public static function getCommentsToProduct($productId)
    {
        $comments = \Yii::$app->cache->get('comments_product_'.$productId);
        if ($comments === false) {
            $comments = CommentModel::find()->where(['idProduct'=>$productId])->all();
            \Yii::$app->cache->add('comments_product_'.$productId,$comments);
        }
        return $comments;
    }

    public static function getUserCommentToProduct($productId,$userId)
    {
        $comments = \Yii::$app->cache->get('comments_product_'.$productId);
        if ($comments === false) {
            $comments = CommentModel::find()->where(['idProduct'=>$productId])->all();
            \Yii::$app->cache->add('comments_product_'.$productId,$comments);
        }
        foreach($comments as $comment)
        {
            if ($comment->idUser == $userId)
                return $comment;
        }
        return null;
    }

    public function afterSave($insert, $changedAttributes)
    {
        \Yii::$app->cache->delete('comments_product_'.$this->idProduct);
        \Yii::$app->cache->delete('product_'.$this->idProduct);
        \Yii::$app->cache->delete('products_category_'.$this->getIdProduct0()->one()->idCategory);
        return parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        \Yii::$app->cache->delete('comments_product_'.$this->idProduct);
        \Yii::$app->cache->delete('product_'.$this->idProduct);
        \Yii::$app->cache->delete('products_category_'.$this->getIdProduct0()->one()->idCategory);
        return parent::beforeDelete();
    }
}
