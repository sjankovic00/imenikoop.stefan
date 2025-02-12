<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Podaci o clanu</title>
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
        }

        .info {
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
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
    </style>
</head>
<body>

<div class="container">
    <h1>Podaci o clanu</h1>

    <div class="info"><span class="label">Ime:</span> <?= htmlspecialchars($member['ime']) ?></div>
    <div class="info"><span class="label">Prezime:</span> <?= htmlspecialchars($member['prezime']) ?></div>
    <div class="info"><span class="label">Broj telefona:</span> <?= htmlspecialchars($member['br_telefona']) ?></div>
    <div class="info"><span class="label">Adresa:</span> <?= htmlspecialchars($member['adresa']) ?></div>
    <div class="info"><span class="label">Email:</span> <?= htmlspecialchars($member['email']) ?></div>
    <div class="info"><span class="label">Opis:</span> <?= htmlspecialchars($member['opis']) ?></div>

    <?php if (!empty($member['website'])): ?>
        <div class="info">
            <span class="label">Website:</span>
            <?= htmlspecialchars($member['website']) ?>
        </div>
    <?php endif; ?>
    <a href="/index" class="back">Nazad na stranu</a>
</div>

</body>
</html>
