<?php

use Core\Database;

require_once '../Core/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['image_id'])) {
    $db = new Database(require '../config.php');

    $image_id = $_POST['image_id'];

    $image = $db->query("SELECT filepath FROM images WHERE id = :id", [':id' => $image_id])->fetch();

    $image_path = __DIR__ . "/../public/" . $image['filepath'];

    $db->query("DELETE FROM user_images WHERE image_id = :image_id", [':image_id' => $image_id]);

    $db->query("DELETE FROM images WHERE id = :id", [':id' => $image_id]);

    if (file_exists($image_path)) {
     unlink($image_path);
    }

    echo json_encode(["success" => true]);
    exit;
} else {
    echo json_encode(["success" => false]);
    exit;
}
