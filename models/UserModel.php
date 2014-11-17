<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $phone
 * @property string $country
 * @property string $city
 * @property integer $zipCode
 * @property string $address
 * @property string $password
 *
 * @property Comment[] $comments
 * @property Order[] $orders
 */
class UserModel extends \yii\db\ActiveRecord implements IdentityInterface
{
    public static function findIdentity($id)
    {
        return static::findOne($id);   
    }

    public static function findIdentityByAccessToken($token, $type=null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->password;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'name', 'phone', 'country', 'city', 'zipCode', 'address', 'password'], 'required'],
            [['zipCode'], 'integer'],
            [['email', 'address', 'password'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 100],
            [['phone', 'country', 'city'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'phone' => 'Phone',
            'country' => 'Country',
            'city' => 'City',
            'zipCode' => 'Zip Code',
            'address' => 'Address',
            'password' => 'Password',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(CommentModel::className(), ['idUser' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(OrderModel::className(), ['idUser' => 'id']);
    }
}
