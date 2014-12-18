<?php

namespace app\models;
use Yii;



class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $users = [
        
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
        '102' => [
            'id' => '102',
            'username' => 'toto',
            'password' => 'toto',
            'authKey' => 'test102key',
            'accessToken' => '102-token',
        ],
    ];

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {

        $session = Yii::$app->getSession();
        if ($session->isActive)
        {
            if($session->get('user')!= null)
            {
                $user = $session->get('user');
                User::ajoutUser($user);
            }
        }
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;

    }
    public static function ajoutUser($user)
    {
        if(isset($user))
        {
            $tabUser = array('id'=>$user->id,'username'=>$user->username,'password'=>$user->password,'authKey'=>$user->authKey, 'accessToken'=>$user->accessToken);
        }
        self::$users[$user->id]=$tabUser;        
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
