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
    public function editMember()
    {

        $id = $_POST['id'];


        if (!empty($_POST['ime'])) {
            $data = [
                'id' => $id,
                'ime' => $_POST['ime'],
                'prezime' => $_POST['prezime'],
                'br_telefona' => $_POST['br_telefona'],
                'adresa' => $_POST['adresa'],
                'email' => $_POST['email'],
                'opis' => $_POST['opis'],
                'website' => $_POST['website'] ?? null,
            ];

            echo json_encode(['success' => $this->userModel->updateMember($data)]);
            return;
        }

        $member = $this->userModel->getMemberById($id);
        echo json_encode($member ? ['success' => true, 'data' => $member] : ['success' => false, 'message' => 'Clan ne postoji']);

    }

    public function deleteMember()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
            $id = $_POST['id'];
            $deleted = $this->userModel->deleteMemberById($id);

            if ($deleted) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Neuspešno brisanje']);
            }
        exit();
    }

}
}
