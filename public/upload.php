<?php

use Core\Database;

session_start();
const BASE_PATH = __DIR__ . '/../';

function base_path($path) {
    return BASE_PATH . $path;
}

require base_path('Core/Database.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['uploadFile'])) {
    $dir = base_path('public/images/');
    $file = $dir . basename($_FILES['uploadFile']['name']);

    // Proveravamo da li je korisnik prijavljen
    if (!isset($_SESSION['id'])) {
        die("Greška: Korisnik nije prijavljen!");
    }

    if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $file)) {
        // Konekcija na bazu
        $db = new Database(require base_path('config.php'));

        // Upis slike u tabelu images
        $db->query("INSERT INTO images(filepath) VALUES(:filepath)", [':filepath' => 'images/' . basename($_FILES['uploadFile']['name'])]);
        $image_id = $db->conection->lastInsertId();

        $user_id = $_SESSION['id'];

        // Provera da li korisnik postoji u members tabeli
        $member = $db->query("SELECT * FROM members WHERE id = :id", [':id' => $user_id])->fetch();
        if (!$member) {
            die("Greška: Korisnik sa tim ID-jem ne postoji u members tabeli!");
        }

        // Upis veze između korisnika i slike u tabelu user_images
        $db->query("INSERT INTO user_images (user_id, image_id) VALUES(:user_id, :image_id)", [':user_id' => $user_id, ':image_id' => $image_id]);

        echo "Slika je uspešno postavljena!";
    } else {
        echo "Slika nije uspešno postavljena!";
    }
}
