<?php
namespace Core;
use Models\Users;

class Authorize
{
    public static function logout()
    {
        session_destroy();
        header("Location: /");
        exit();
    }

    public static function login($username, $password, Users $us)
    {
        $user = $us->username($username);
        if ($user && $us->pwd($password, $user['password'])) {
            session_start();
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['id'] = $user['id'];
            return true;
        }
        return false;
}
}