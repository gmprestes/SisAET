<?php

require_once '../db.php';

class ASPNETUser
{
    private $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public static function GetUserByName($usuario)
    {
        $db = DB::getInstance();
        $user = $db->ASPNETUsers->findOne(array('Username' => $usuario));

        return $user;
    }

    public static function GetUserById($id)
    {
        $db = DB::getInstance();
        $user = $db->ASPNETUsers->findOne(array('_id' => $id));

        return $user;
    }

    public static function AlterarSenha($usuario, $novasenha)
    {
        $db = DB::getInstance();

        $user = $db->ASPNETUsers->findOne(array('Username' => $usuario));
        if (!empty($user)) {
            $password_salt = $user['Salt'];
            $bytes = mb_convert_encoding($novasenha, 'UTF-16LE');
            $salt = base64_decode($password_salt);
            $password = base64_encode(sha1($salt.$bytes, true));

            $update = array('$set' => array('Password' => $password));
            $db->ASPNETUsers->update(array('Username' => $usuario), $update);

            return true;
        } else {
            return false;
        }
    }

    public static function ValidateUser($usuario, $senha)
    {
        $userOK = false;
        $db = DB::getInstance();

        $user = $db->ASPNETUsers->findOne(array('Username' => $usuario));
        if (!empty($user)) {
            if ($user['IsApproved'] == true) {
                $hashed_password = $user['Password'];
                $password_salt = $user['Salt'];
                $bytes = mb_convert_encoding($senha, 'UTF-16LE');
                $salt = base64_decode($password_salt);
                $password = base64_encode(sha1($salt.$bytes, true));

                if ($password == $hashed_password) {
                    $userOK = true;
                }
            }
        }

        return $userOK;
    }

    public static function CreateUser($usuario, $senha)
    {
        $db = DB::getInstance();

        $password_salt = '4Ynmyxlu6hwV86xbhagdCQ==';
        $bytes = mb_convert_encoding($senha, 'UTF-16LE');
        $salt = base64_decode($password_salt);
        $password = base64_encode(sha1($salt.$bytes, true));

        $user = array(
                '_id' => strtolower(trim(com_create_guid(), '{}')),
                'ApplicationName' => '/',
                'CreationDate' => new MongoDate(),
                'Email' => $usuario,
                'FailedPasswordAnswerAttemptCount' => 0,
                'FailedPasswordAnswerAttemptWindowStart' => new MongoDate(),
                'FailedPasswordAttemptCount' => 0,
                'FailedPasswordAttemptWindowStart' => new MongoDate(),
                'IsApproved' => true,
                'IsLockedOut' => false,
                'LastActivityDate' => new MongoDate(),
                'LastLockoutDate' => new MongoDate(),
                'LastLoginDate' => new MongoDate(),
                'LastPasswordChangedDate' => new MongoDate(),
                'Password' => $password,
                'PasswordAnswer' => '2xVa6e3Siu4F6aIqdY/DYl1E8MI=',
                'PasswordQuestion' => 'wololo',
                'Salt' => $password_salt,
                'Username' => $usuario,
                'Comment' => '', );

        $db->ASPNETUsers->insert($user);
    }
}
