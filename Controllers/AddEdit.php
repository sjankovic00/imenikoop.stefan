<?php
namespace Controllers;
use Core\Database;
use Helpers\Functions;
use Models\Users;

class AddEdit
{

    public $userModel;
    public function __construct()
    {
        $db = new Database(require \base_path('config.php'));
        $this->userModel = new Users($db);
    }
    public function write()
    {
        $data = [
            'ime' => $_POST['ime'] ?? '',
            'prezime' => $_POST['prezime'] ?? '',
            'br_telefona' => $_POST['br_telefona'] ?? '',
            'adresa' => $_POST['adresa'] ?? '',
            'email' => $_POST['email'] ?? '',
            'opis' => $_POST['opis'] ?? '',
            'website' => $_POST['website'] ?? null,
        ];

        $this->userModel->addMember($data);

        header('Location: /index');
        exit();
    }
    public function showAdd()
    {
        Functions::view('add.view.php');
    }
}
