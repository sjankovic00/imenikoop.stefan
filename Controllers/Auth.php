<?php
namespace Controllers;
use Core\Authorize;
use Core\Database;
use Helpers\Functions;
use Models\Users;

class Auth
{
    public function login()
    {
        if($_SERVER["REQUEST_METHOD"] == "GET"){
            Functions::view('login.view.php');

        } else if($_SERVER["REQUEST_METHOD"] == "POST"){

            $db = new Database(require \base_path('config.php'));
            $user = new Users($db);

            $username = $_POST['username'];
            $password = $_POST['password'];

            if (Authorize::login($username, $password, $user)) {
                header("Location: /index");
                exit();
            }
            else {
                $_SESSION['error'] = " Wrong username or password.";
                header("Location: /");
                exit();
            }

        }
    }
    public function logout()
    {
        Authorize::logout();
    }
}