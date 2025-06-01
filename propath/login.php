<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: quizz.php");
    exit();
}

$error = "";
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telepon = $_POST['no_telepon'];

    // Validasi sederhana
    if (empty($nama) || empty($email)) {
        $error = "Nama dan email harus diisi.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } else {
        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "", "kepercayaan_diri");
        if ($conn->connect_error) {
            die("Koneksi database gagal: " . $conn->connect_error);
        }

        // Cek apakah email sudah terdaftar
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id'];
            header("Location: quizz.php");
            exit();
        } else {
            // Insert data pengguna baru
            $stmt = $conn->prepare("INSERT INTO users (nama, email, no_telepon) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nama, $email, $no_telepon);
            if ($stmt->execute()) {
                $_SESSION['user_id'] = $conn->insert_id;
                header("Location: quizz.php");
                exit();
            } else {
                $error = "Terjadi kesalahan saat menyimpan data.";
            }
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kuis Kepercayaan Diri</title>
    <style>
        body {
            font-family: sans-serif;
            background: linear-gradient(135deg, #ADD8E6, #8A2BE2);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #fff;
            animation: gradientAnimation 10s infinite alternate;
        }

        @keyframes gradientAnimation {
            0% { background: linear-gradient(135deg, #ADD8E6, #8A2BE2); }
            100% { background: linear-gradient(135deg, #8A2BE2, #ADD8E6); }
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            backdrop-filter: blur(10px);
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            color: #fff;
            margin-bottom: 20px;
            animation: pulse 2s infinite alternate;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.05); }
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            color: #eee;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        button[type="submit"] {
            background-color: #6A5ACD;
            color: #fff;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            animation: slideInUp 1s ease-out;
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        button[type="submit"]:hover {
            background-color: #483D8B;
            transform: translateY(-2px);
        }

        .error {
            color: #FFD700;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Selamat Datang di Kuis Kepercayaan Diri</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="no_telepon">Nomor Telepon:</label>
                <input type="tel" id="no_telepon" name="no_telepon">
            </div>
            <button type="submit" name="submit">Mulai Kuis</button>
        </form>
    </div>
</body>
</html>