<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj novog člana</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007BFF;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1>Dodaj novog clana</h1>
    <form action="/add" method="POST">
        <div class="form-group">
            <label for="ime">Ime:</label>
            <input type="text" id="ime" name="ime" required>
        </div>
        <div class="form-group">
            <label for="prezime">Prezime:</label>
            <input type="text" id="prezime" name="prezime" required>
        </div>
        <div class="form-group">
            <label for="br_telefona">Broj telefona:</label>
            <input type="text" id="br_telefona" name="br_telefona" required>
        </div>
        <div class="form-group">
            <label for="adresa">Adresa:</label>
            <input type="text" id="adresa" name="adresa">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="opis">Opis:</label>
            <textarea id="opis" name="opis" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label for="website">Website (ako postoji):</label>
            <input type="url" id="website" name="website">
        </div>
<!--        <div class="form-group">-->
<!--            <label for="uploadFile">Slika:</label>-->
<!--            <input type="file" name="uploadFile" id="uploadFile">-->
<!--        </div>-->

        <button type="submit">Dodaj clana</button>
    </form>
    <a class="back-link" href="/index">Nazad na listu članova</a>
</div>
</body>
</html>
