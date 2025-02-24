<?php
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        .members-list {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .member {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .member:last-child {
            border-bottom: none;
        }

        .member a {
            text-decoration: none;
            font-weight: bold;
            color: #2c3e50;
        }

        .member a:hover {
            color: #2980b9;
        }

        .buttons {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .buttons a {
            display: block;
            text-align: center;
            padding: 10px 15px;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            width: 100px;
        }

        .logout {
            background-color: #e74c3c;
        }

        .logout:hover {
            background-color: #c0392b;
        }

        .add {
            background-color: #27ae60;
        }

        .add:hover {
            background-color: #229954;
        }

        .edit-button {
            background-color: #2ecc71;
            padding: 5px 10px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .edit-button:hover {
            background-color: #28b463;
        }
    </style>
</head>
<body>

<div class="container">
    <p>Prijavljeni ste kao <?= htmlspecialchars($role); ?>.</p>

    <div class="members-list">
        <?php foreach ($members as $member): ?>
            <div class="member">
                <div>
                    <a href="/member?id=<?= $member['id']; ?>">
                        <?= htmlspecialchars($member['ime'] . " " . $member['prezime']); ?>
                    </a>
                    <br>
                    <small>Broj telefona: <?= htmlspecialchars($member['br_telefona']); ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="buttons">
    <a href="/logout" class="logout">Log Out</a>
    <?php if ($role === 'admin'): ?>
        <a href="/add" class="add">Add</a>
    <?php endif; ?>
</div>
