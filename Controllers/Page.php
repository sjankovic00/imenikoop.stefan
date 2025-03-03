<?php
namespace Controllers;
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
use Core\Database;
use Helpers\Functions;
use Models\Users;


class Page{
    public function index()
    {
        $db = new Database(require \base_path('config.php'));
        $userModel = new Users($db);

        $members = $userModel->getAllMembers();

        Functions::view('index.view.php', [
            'role' => isset($_SESSION['role']) ? $_SESSION['role'] : 'Guest',
            'members' => $members
        ]);

    }
    public function single()
    {
        $db = new Database(require \base_path('config.php'));
        $user = new Users($db);

        $id =(int) $_GET['id'];

        $member = $user->getMemberById($id);

        if (!$member) {
            die("Error!");
        }

        $images = $user->getImageById($id);

        Functions::view('single.view.php', [
            'member' => $member,
            'images' => $images
        ]);
    }


}