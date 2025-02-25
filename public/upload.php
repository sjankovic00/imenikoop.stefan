<?php

use Core\Database;

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../Core/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['uploadFile']) && isset($_POST['user_id'])) {

    $db = new Database(require '../config.php');

    $dir = '../public/images/';
    $filename = 'images/' . basename($_FILES['uploadFile']['name']);
    $filepath = 'images/' . $filename;
    $target_file = $dir . $filename;

    $user_id = $_POST['user_id'];

    // Provera da li član postoji
    $member = $db->query("SELECT * FROM members WHERE id = :id", [':id' => $user_id])->fetch();
    if (!$member) {
        echo json_encode(["success" => false]);
        exit;
    }

    // Upload slike
    if (!move_uploaded_file($_FILES['uploadFile']['tmp_name'], $target_file)) {
        echo json_encode(["success" => false]);
        exit;
    }

    // Upis u images tabelu
    $db->query("INSERT INTO images(filepath) VALUES(:filepath)", [':filepath' => $filepath]);
    $image_id = $db->connection->lastInsertId();

    if (!$image_id) {
        echo json_encode(["success" => false]);
        exit;
    }

    // Povezivanje slike sa članom
    $db->query("INSERT INTO user_images (user_id, image_id) VALUES(:user_id, :image_id)", [
        ':user_id' => $user_id,
        ':image_id' => $image_id
    ]);

    echo json_encode(["success" => true, "filepath" => $filepath]);
    exit;
}
