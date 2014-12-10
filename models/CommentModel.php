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
}
