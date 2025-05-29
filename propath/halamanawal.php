<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tes Minat Karir</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            transform: perspective(1000px) rotateX(-10deg);
            transition: all 0.4s ease;
        }
        .card:hover {
            transform: perspective(1000px) rotateX(0deg);
            box-shadow: 0 30px 50px rgba(0, 0, 0, 0.15);
        }
        h1 {
            color: #4a4a4a;
            margin-bottom: 20px;
            font-weight: 600;
        }
        p {
            color: #6a6a6a;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .start-button {
            display: inline-block;
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 1px;
            transition: transform 0.3s ease;
            box-shadow: 0 10px 20px rgba(118, 75, 162, 0.3);
        }
        .start-button:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 25px rgba(118, 75, 162, 0.4);
        }
        .decorative-line {
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, #667eea, #764ba2);
            margin: 20px auto;
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Tes Minat Karir</h1>
            <div class="decorative-line"></div>
            <p>Temukan potensi dan minat terdalammu melalui tes komprehensif ini. Jawab 20 pertanyaan untuk mengungkap jalur karir yang paling sesuai dengan kepribadianmu.</p>
            <a href="quiz.php" class="start-button">Mulai Tes Sekarang</a>
        </div>
    </div>
</body>
</html>
