<?php
session_start();
$role = $_SESSION['role'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member information</title>
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
    <h1>Member information</h1>
    <div class="info"><span class="label">Name:</span> <?= htmlspecialchars($member['name']) ?></div>
    <div class="info"><span class="label">Surname:</span> <?= htmlspecialchars($member['surname']) ?></div>
    <div class="info"><span class="label">Phone:</span> <?= htmlspecialchars($member['phone_number']) ?></div>
    <div class="info"><span class="label">Address:</span> <?= htmlspecialchars($member['address']) ?></div>
    <div class="info"><span class="label">Email:</span> <?= htmlspecialchars($member['email']) ?></div>
    <div class="info"><span class="label">Description:</span> <?= htmlspecialchars($member['description']) ?></div>

        <h3>Picture:</h3>
    <div class="user-images">
        <?php if (!empty($images)): ?>

            <?php foreach ($images as $image): ?>
                <div class="image-container">
                    <img src="/<?= htmlspecialchars($image['filepath']) ?>" alt="Profilna slika" class="user-image">
                    <br>
                    <?php if ($role === 'admin'): ?>
                        <button type="button" class="delete-image-btn" data-image-id="<?= $image['id'] ?>">Delete picture</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-images-message">No pictures available.</p>
        <?php endif; ?>
    </div>




    <?php if ($role === 'admin'): ?>
        <div class="upload-form">
            <h3>Add a picture</h3>
            <form id="uploadForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?= $member['id']; ?>">
                <label for="uploadFile">Select a picture:</label>
                <input type="file" name="uploadFile" id="uploadFile" required>
                <button type="submit">Add</button>
            </form>
        </div>

        <div class="actions">
            <button class="edit-btn" data-id="<?= $member['id']; ?>">Edit</button>
            <button class="delete-btn" data-id="<?= $member['id']; ?>">Delete</button>
        </div>

    <?php endif; ?>

    <a href="/index" class="back">Back to the page</a>
</div>

<div id="editModal">
    <h2>Edit data</h2>
    <form id="editForm">
        <input type="hidden" id="edit-id" name="id">

        <label>Name:</label>
        <input type="text" id="edit-name" name="name" class="form-input">
        <br>
        <label>Surname:</label>
        <input type="text" id="edit-surname" name="surname" class="form-input">
        <br>
        <label>Phone:</label>
        <input type="text" id="edit-phone" name="phone_number" class="form-input">
        <br>
        <label>Address:</label>
        <input type="text" id="edit-address" name="address" class="form-input">
        <br>
        <label>Email:</label>
        <input type="email" id="edit-email" name="email" class="form-input">
        <br>
        <label>Description:</label>
        <input type="text" id="edit-opis" name="description" class="form-input">
        <br>
        <label>Website:</label>
        <input type="text" id="edit-website" name="website" class="form-input">
        <br>
        <br>
        <button type="button" id="saveEdit">Save</button>
        <button type="button" class="modal-close">Close</button>
    </form>
</div>
<script src="script.js"></script>

</body>
</html>
