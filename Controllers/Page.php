<?php
namespace Controllers;
use Core\Database;
use Helpers\Functions;
use Models\Users;

class Page{
    public function index()
    {
        $db = new Database(require \base_path('config.php'));
        $userModel = new Users($db);

        $members = $userModel->members();

        Functions::view('index.view.php', [
            'role' => isset($_SESSION['role']) ? $_SESSION['role'] : 'Guest',
            'members' => $members
        ]);

    }
    public function single()
    {
        $db = new Database(require \base_path('config.php'));
        $user = new Users($db);

        $id = $_GET['id'];

        $member=$user->getMember($id);

        Functions::view('single.view.php', ['member'=>$member]);
    }
}