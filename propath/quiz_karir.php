<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Cek login
if(!isset($_SESSION['user_id'])) {
    header("Location: login_karir.php");
    exit();
}

$questions = [
    "Perencanan karier yang tepat akan mengantarkan kesuksesan.",
    "Ketika ada penawaran pekerjan yang diberikan orang lain saya langsung menerima.",
    "Sudah paham dengan minat apa yang saya inginkan.",
    "Dengan kelebihan yang saya miliki menjadikan saya semakin percaya diri.",
    "Saya dapat mengetahui kekurangan yang ada dalam diri saya.",
    "Susah untuk menemukan kelebihan diri sendiri.",
    "Saya merasa kelebihan yang dimiliki membuat lebih percaya diri.",
    "Saya merasa depresi karena tidak memiliki minat dari dalam diri.",
    "Saya merasa pesimis ketika melihat persyaratan memasuki dunia kerja.",
    "Semangat ketika pertama kali melihat persyaratan melamar pekerjaan.",
    "Saya selalu berfikir mencari persyaratan kerja itu susah.",
    "Ketika gagal maka saya siap menanggung semua resiko yang terjadi.",
    "Selalu berusaha mencari informasi tentang dunia kerja.",
    "Mengembangkan keterampilan yang telah saya miliki menjadi beban terberat.",
    "Selalu tidak berfikir kreatif untuk menciptakan inovasi pekerjan yang baru.",
    "Untuk menunjang keterampilan, saya selalu berkumpul dengan orang-orang yang sama keterampilanya.",
    "Saya selalu giat melakukan ikut berbagi macam latihan keterampilan agar semakin bagus.",
    "Menemukan minat yang mendukung keberhasilan dimasa depan saya itu sangat sulit.",
    "Saya susah mengembangkan ketermapilan yang dimiliki.",
    "Saya tidak merencanakan pekerjan dengan baik untuk masa depan .",
    "Kelebihan yang saya miliki terakadang mebuat menjadi sombong.",
    "Menyusun rencana untuk pekerjan yang tepat sesuai keinginan.",
    "Terdorong untuk selalu menciptakan inovasi-inovasi yang lebih baru.",
    "Saya selalu bersungguh-sunguh dalam melaksanakan perencanan karier.",
    "saya tidak siap ketika yang direncanakan itu gagal.",
    "Saya berifikir penawaran pekerjan dari orang lain itu jelek.",
    "Saya tidak bisa menerima ketika saya gagal dalam usaha.",
    "Lingkungan tidak mendukung sepenuhnya dengan bakat yang sudah saya miliki.",
    "Terkadang saya tidak yakin dengan bakat yang di miliki akan mengantarkan kesuksesan.",
    "Merasa gugup ketika menghadapi resiko.",
    "Susah menerima rekomendasi penawaran kerja dari teman.",
    "Susah mengembangkan bakat yang dimiliki.",
    "Berusaha memaksimalkan keterampilan yang telah dimiliki untuk menunjang karier.",
    "Merasa sedih ketika mengetahui kekurangan kita.",
    "Tidak terlalu ambil pusing untuk memikirkan perencanan karier masa depan.",
    "Kreasi terbaru sangat dibutuhkan untuk menentukan karier saya.",
    "Acuh terrhadap rekomendasi pekerjanan dari teman.",
    "Saya kurang yakin dengan rencana karir yang telah saya buat.",
    "Saya belum tahu dengan keterampilan yang saya miliki.",
    "Ketika mengetahui kekurangan yang dimiliki, saya berusaha untuk memperbaiki.",
    "Saya terkadang kurang bisa membuat suatu hal menjadi lebih menarik .",
    "Selalu bersungguh-sungguh dalam mempersiapkan persyaratn lamara kerja."
];

$options = [
    "Sangat Setuju" => 4,
    "Setuju" => 3,
    "Tidak Setuju" => 2,
    "Sangat Tidak Setuju" => 1
];

$showForm = true;
$errorMessage = '';
$resultHTML = '';
$unansweredQuestions = [];

// Inisialisasi array jawaban di session jika belum ada
if (!isset($_SESSION['quiz_answers'])) {
    $_SESSION['quiz_answers'] = [];
}

if (isset($_POST['submit'])) {
    // Simpan jawaban yang dikirim ke session
    foreach ($questions as $key => $question) {
        if (isset($_POST['q_' . $key])) {
            $_SESSION['quiz_answers'][$key] = $_POST['q_' . $key];
        }
    }
    
    // Periksa apakah semua pertanyaan sudah dijawab
    $unansweredQuestions = [];
    foreach ($questions as $key => $question) {
        if (!isset($_SESSION['quiz_answers'][$key]) || $_SESSION['quiz_answers'][$key] === '') {
            $unansweredQuestions[] = $key + 1; // Simpan nomor pertanyaan (dimulai dari 1)
        }
    }
    
    if (empty($unansweredQuestions)) {
        // Semua pertanyaan sudah dijawab, hitung skor
        $totalScore = 0;
        foreach ($_SESSION['quiz_answers'] as $key => $answer) {
            $totalScore += $options[$answer];
        }
        
        $category = "";
        if ($totalScore >= 80 && $totalScore <= 100) {
            $category = "Perencanaan Karir sangat tinggi";
        } elseif ($totalScore >= 60 && $totalScore <= 79) {
            $category = "Perencanaan Karir tinggi";
        } elseif ($totalScore >= 40 && $totalScore <= 59) {
            $category = "Perencanaan Karir sedang";
        } elseif ($totalScore >= 20 && $totalScore <= 39) {
            $category = "Perencanaan Karir rendah";
        } else {
            $category = "Perencanaan Karir sangat rendah";
        }

        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "", "perencanaan_karir");
        if ($conn->connect_error) {
            $errorMessage = "<p style='color: red;'>Koneksi database gagal: " . $conn->connect_error . "</p>";
        } else {
            // Simpan hasil kuis ke database
            $user_id = $_SESSION['user_id'];
            $stmt = $conn->prepare("INSERT INTO hasil_kuis (user_id, skor, kategori) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $user_id, $totalScore, $category);
            
            if ($stmt->execute()) {
                $resultHTML = "<div class='result-container'>
                    <h2>Hasil Kuis</h2>
                    <p>Skor Anda: <strong>" . $totalScore . "</strong></p>
                    <p class='result-category'>Kategori: <strong>" . $category . "</strong></p>
                    <p><a href='logout_karir.php' style='color: #fff; text-decoration: none;'>Logout</a></p>
                </div>";
                $showForm = false;
                
                // Reset session untuk quiz
                unset($_SESSION['quiz_answers']);
            } else {
                $errorMessage = "<p style='color: red;'>Terjadi kesalahan saat menyimpan hasil ke database: " . $stmt->error . "</p>";
            }
            
            $stmt->close();
            $conn->close();
        }
    } else {
        // Ada pertanyaan yang belum dijawab
        $errorMessage = "<p style='color: red;'>Harap jawab pertanyaan nomor: " . implode(", ", $unansweredQuestions) . ".</p>";
        // Form akan ditampilkan kembali dengan nilai yang sudah diisi sebelumnya
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuis Perencanaan Karir</title>
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

        .quiz-container {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            backdrop-filter: blur(10px);
            animation: fadeIn 1s ease-out;
            max-width: 800px;
            width: 90%;
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

        .question {
            margin-bottom: 20px;
            color: #eee;
            font-size: 1.1em;
            text-align: left;
        }

        .question.unanswered {
            border-left: 4px solid #ff6b6b;
            padding-left: 15px;
            animation: highlight 1.5s infinite alternate;
        }

        @keyframes highlight {
            from { border-color: #ff6b6b; }
            to { border-color: #ff9b9b; }
        }

        .options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }

        .option-label {
            display: block;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            color: #ddd;
            position: relative;
            overflow: hidden;
        }

        .option-label:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        input[type="radio"] {
            display: none;
        }

        input[type="radio"]:checked + .option-label {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: bold;
        }

        button {
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

        button:hover {
            background-color: #483D8B;
            transform: translateY(-2px);
        }

        .result-container {
            margin-top: 30px;
            color: #fff;
            font-size: 1.2em;
            animation: zoomIn 1s ease-out;
        }

        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        .result-category {
            font-weight: bold;
            margin-top: 10px;
            font-size: 1.3em;
        }

        .option-label::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent 5%, #4682B4 50%, transparent 95%);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s;
        }

        .scroll-to-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #6A5ACD;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5em;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            z-index: 100;
            display: none;
        }

        .scroll-to-button:hover {
            background-color: #483D8B;
        }
    </style>
</head>
<body>
    <div class="quiz-container">
        <h1>Kuis Perencanaan Karir</h1>
        
        <?php echo $errorMessage; ?>
        <?php echo $resultHTML; ?>
        
        <?php if ($showForm): ?>
        <form method="post" action="">
            <?php foreach ($questions as $key => $question): 
                $isUnanswered = in_array($key + 1, $unansweredQuestions);
                $questionClass = $isUnanswered ? 'question unanswered' : 'question';
                $questionId = 'question_' . $key;
            ?>
            <div class="<?php echo $questionClass; ?>" id="<?php echo $questionId; ?>">
                <p><?php echo ($key + 1) . ". " . $question; ?></p>
                <div class="options">
                    <?php foreach ($options as $option => $value): ?>
                    <div>
                        <input type="radio" name="q_<?php echo $key; ?>" id="q_<?php echo $key; ?>_<?php echo $option; ?>" value="<?php echo $option; ?>" 
                            <?php if (isset($_SESSION['quiz_answers'][$key]) && $_SESSION['quiz_answers'][$key] === $option) echo 'checked'; ?>>
                        <label class="option-label" for="q_<?php echo $key; ?>_<?php echo $option; ?>"><?php echo $option; ?></label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
            
            <button type="submit" name="submit">Lihat Hasil</button>
        </form>

        <?php if (!empty($unansweredQuestions)): ?>
        <button id="scrollToFirstUnanswered" class="scroll-to-button" title="Scroll to first unanswered question">↑</button>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Menampilkan tombol scroll
                document.getElementById('scrollToFirstUnanswered').style.display = 'flex';
                
                // Scroll ke pertanyaan yang belum dijawab pertama
                function scrollToFirstUnanswered() {
                    <?php if (!empty($unansweredQuestions)): ?>
                    const firstUnanswered = document.getElementById('question_<?php echo $unansweredQuestions[0]-1; ?>');
                    if (firstUnanswered) {
                        firstUnanswered.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    <?php endif; ?>
                }
                
                // Auto scroll ke pertanyaan pertama yang belum dijawab
                setTimeout(scrollToFirstUnanswered, 500);
                
                // Event listener untuk tombol scroll
                document.getElementById('scrollToFirstUnanswered').addEventListener('click', scrollToFirstUnanswered);
            });
        </script>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>