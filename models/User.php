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
 * @property int $role
 *
 * @property Comment[] $comments
 * @property Order[] $orders
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    const ROLE_USER = 1;
    const ROLE_ADMIN = 10;

    public static function findIdentity($id)
    {
        return static::findOne($id);   
    }

    public static function findIdentityByAccessToken($token, $type=null)
    {
        return null;
    }

    public static function findByUsername($username)
    {
        $user = static::find()
        ->where(['email' => $username])
        ->one();
        return $user!=null ? new static($user) : null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === sha1($authKey);
    }

    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }

    public function validateRole($role)
    {
        if ($role == ROLE_ADMIN)
            return ROLE_ADMIN == $this->role;
        elseif ($role == ROLE_USER)
            return ROLE_ADMIN == $this->role || ROLE_USER == $this->role;
        else
            return true; 
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
            [['email', 'name', 'phone', 'country', 'city', 'zipCode', 'address', 'password', 'role'], 'required'],
            [['zipCode'], 'integer'],
            [['email'], 'email'],
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
            'role' => 'Role',
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
