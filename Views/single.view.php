<?php
session_start();
$role = $_SESSION['role'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Podaci o članu</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .container {
            background-color: white;
            padding: 20px;
            max-width: 500px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 100px;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .back:hover {
            background-color: #45a049;
        }

        .edit-btn, .delete-btn {
            display: inline-block;
            text-align: center;
            margin: 10px 5px;
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .edit-btn:hover {
            background-color: #007bb5;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }

        .upload-form {
            margin-top: 20px;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .upload-form input[type="file"] {
            margin-bottom: 10px;
        }

        .user-image {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
        }

        /* ======== MODAL STILOVI ======== */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        #editModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            width: 400px;
            z-index: 1000;
        }

        .modal-close {
            display: block;
            text-align: center;
            background-color: #f44336;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .modal-close:hover {
            background-color: #d32f2f;
        }

        .form-input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Podaci o članu</h1>
    <div class="info"><span class="label">Ime:</span> <?= htmlspecialchars($member['ime']) ?></div>
    <div class="info"><span class="label">Prezime:</span> <?= htmlspecialchars($member['prezime']) ?></div>
    <div class="info"><span class="label">Broj telefona:</span> <?= htmlspecialchars($member['br_telefona']) ?></div>
    <div class="info"><span class="label">Adresa:</span> <?= htmlspecialchars($member['adresa']) ?></div>
    <div class="info"><span class="label">Email:</span> <?= htmlspecialchars($member['email']) ?></div>
    <div class="info"><span class="label">Opis:</span> <?= htmlspecialchars($member['opis']) ?></div>

    <h3>Slika korisnika:</h3>
    <div class="user-images">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $image): ?>
                <img src="/<?= htmlspecialchars($image) ?>" alt="Profilna slika" class="user-image">
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nema dostupnih slika za ovog korisnika.</p>
        <?php endif; ?>
    </div>



    <?php if ($role === 'admin'): ?>
        <div class="upload-form">
            <h3>Dodaj sliku</h3>
            <form id="uploadForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?= $member['id']; ?>">
                <label for="uploadFile">Izaberite sliku:</label>
                <input type="file" name="uploadFile" id="uploadFile" required>
                <button type="submit">Dodaj sliku</button>
            </form>
        </div>

        <div class="actions">
            <button class="edit-btn" data-id="<?= $member['id']; ?>">Izmeni</button>
            <button class="delete-btn" data-id="<?= $member['id']; ?>">Obriši</button>
        </div>

    <?php endif; ?>

    <a href="/index" class="back">Nazad na stranu</a>
</div>

<!-- Overlay pozadina -->
<div class="modal-overlay"></div>

<!-- Modal za izmenu -->
<div id="editModal">
    <h2>Izmeni podatke</h2>
    <form id="editForm">
        <input type="hidden" id="edit-id" name="id">

        <label>Ime:</label>
        <input type="text" id="edit-name" name="ime" class="form-input">
        <br>
        <label>Prezime:</label>
        <input type="text" id="edit-surname" name="prezime" class="form-input">
        <br>
        <label>Broj telefona:</label>
        <input type="text" id="edit-phone" name="br_telefona" class="form-input">
        <br>
        <label>Adresa:</label>
        <input type="text" id="edit-address" name="adresa" class="form-input">
        <br>
        <label>Email:</label>
        <input type="email" id="edit-email" name="email" class="form-input">
        <br>
        <label>Opis:</label>
        <input type="text" id="edit-opis" name="opis" class="form-input">
        <br>
        <label>Website:</label>
        <input type="text" id="edit-website" name="website" class="form-input">
        <br>
        <br>
        <button type="button" id="saveEdit">Sačuvaj</button>
        <button type="button" class="modal-close">Zatvori</button>
    </form>
</div>
<script src="script.js"></script>

</body>
</html>
