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
    public function add()
    {
        $data = [
            'name' => $_POST['name'] ?? '',
            'surname' => $_POST['surname'] ?? '',
            'phone_number' => $_POST['phone_number'] ?? '',
            'address' => $_POST['address'] ?? '',
            'email' => $_POST['email'] ?? '',
            'description' => $_POST['description'] ?? '',
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


        if (!empty($_POST['name'])) {
            $data = [
                'id' => $id,
                'name' => $_POST['name'] ?? '',
                'surname' => $_POST['surname'] ?? '',
                'phone_number' => $_POST['phone_number'] ?? '',
                'address' => $_POST['address'] ?? '',
                'email' => $_POST['email'] ?? '',
                'description' => $_POST['description'] ?? '',
                'website' => $_POST['website'] ?? null,
            ];

            echo json_encode(['success' => $this->userModel->updateMember($data)]);
            return;
        }

        $member = $this->userModel->getMemberById($id);
        echo json_encode($member ? ['success' => true, 'data' => $member] : ['success' => false, 'message' => 'Member does not exist']);

    }

    public function deleteMember()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
            $id = $_POST['id'];
            $deleted = $this->userModel->deleteMemberById($id);

            if ($deleted) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Delete failed']);
            }
        }
        exit();
    }
}
