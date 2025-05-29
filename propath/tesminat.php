<?php
session_start();

// Daftar pertanyaan
$questions = array(
    array(
        'text' => 'Di waktu luang, Anda lebih suka:',
        'options' => array(
            array('text' => 'Membaca buku', 'category' => 'intelektual'),
            array('text' => 'Bermain olahraga', 'category' => 'fisik'),
            array('text' => 'Menggambar atau membuat kerajinan', 'category' => 'seni'),
            array('text' => 'Berkumpul dengan teman', 'category' => 'sosial')
        )
    ),
    array(
        'text' => 'Apa yang paling Anda sukai dalam pelajaran di sekolah?',
        'options' => array(
            array('text' => 'Matematika dan logika', 'category' => 'intelektual'),
            array('text' => 'Pelajaran olahraga', 'category' => 'fisik'),
            array('text' => 'Seni atau musik', 'category' => 'seni'),
            array('text' => 'Diskusi dan kerja kelompok', 'category' => 'sosial')
        )
    ),
    array(
        'text' => 'Dalam sebuah tim, Anda cenderung:',
        'options' => array(
            array('text' => 'Mencari solusi atau strategi', 'category' => 'intelektual'),
            array('text' => 'Menjadi pemimpin dalam aksi', 'category' => 'fisik'),
            array('text' => 'Mengekspresikan ide kreatif', 'category' => 'seni'),
            array('text' => 'Mengkoordinasi dan mendukung anggota tim', 'category' => 'sosial')
        )
    ),
    array(
        'text' => 'Cita-cita ideal Anda adalah menjadi:',
        'options' => array(
            array('text' => 'Peneliti atau profesor', 'category' => 'intelektual'),
            array('text' => 'Atlet profesional', 'category' => 'fisik'),
            array('text' => 'Seniman atau desainer', 'category' => 'seni'),
            array('text' => 'Konselor atau guru', 'category' => 'sosial')
        )
    )
);

// Definisi hasil berdasarkan kategori
$resultDescriptions = array(
    'intelektual' => array(
        'title' => 'Minat Intelektual',
        'description' => 'Anda memiliki potensi yang kuat di bidang akademis dan analitis. Anda mungkin cocok menjadi peneliti, profesor, programmer, atau konsultan yang membutuhkan kemampuan berpikir kritis dan pemecahan masalah.'
    ),
    'fisik' => array(
        'title' => 'Minat Fisik',
        'description' => 'Anda memiliki bakat di bidang yang membutuhkan ketangkasan dan kekuatan fisik. Karir seperti atlet, pelatih, instruktur kebugaran, atau profesi yang membutuhkan kemampuan gerak tubuh mungkin cocok untuk Anda.'
    ),
    'seni' => array(
        'title' => 'Minat Seni',
        'description' => 'Kreativitas adalah kekuatan Anda. Anda mungkin akan berkembang di bidang desain, musik, seni rupa, fotografi, atau profesi lain yang membutuhkan imajinasi dan ekspresi artistik.'
    ),
    'sosial' => array(
        'title' => 'Minat Sosial',
        'description' => 'Kemampuan interpersonal Anda sangat menonjol. Profesi seperti konselor, guru, manajer sumber daya manusia, atau pekerjaan yang berhubungan dengan pemberdayaan dan komunikasi mungkin sangat sesuai dengan Anda.'
    )
);

// Inisialisasi atau reset sesi
if (!isset($_SESSION['current_question'])) {
    $_SESSION['current_question'] = 0;
    $_SESSION['answers'] = array();
}

// Proses jawaban
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['restart'])) {
        // Reset sesi
        $_SESSION['current_question'] = 0;
        $_SESSION['answers'] = array();
        $_SESSION['result'] = null;
    } elseif (isset($_POST['category'])) {
        // Tambahkan jawaban
        $_SESSION['answers'][] = $_POST['category'];
        
        // Pindah ke pertanyaan berikutnya atau hitung hasil
        if ($_SESSION['current_question'] < count($questions) - 1) {
            $_SESSION['current_question']++;
        } else {
            // Hitung hasil
            $categoryScores = array(
                'intelektual' => 0,
                'fisik' => 0,
                'seni' => 0,
                'sosial' => 0
            );

            foreach ($_SESSION['answers'] as $category) {
                $categoryScores[$category]++;
            }

            // Temukan kategori dengan skor tertinggi
            $maxScore = max($categoryScores);
            $dominantCategories = array_keys($categoryScores, $maxScore);
            $_SESSION['result'] = $dominantCategories[0];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tes Minat Karir</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4 text-center">Tes Minat Karir</h1>
        
        <?php if (!isset($_SESSION['result'])): ?>
            <div>
                <h2 class="text-xl font-semibold mb-4">
                    <?php echo htmlspecialchars($questions[$_SESSION['current_question']]['text']); ?>
                </h2>
                
                <form method="post" class="space-y-3">
                    <?php foreach ($questions[$_SESSION['current_question']]['options'] as $option): ?>
                        <button 
                            type="submit" 
                            name="category" 
                            value="<?php echo htmlspecialchars($option['category']); ?>" 
                            class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600"
                        >
                            <?php echo htmlspecialchars($option['text']); ?>
                        </button>
                    <?php endforeach; ?>
                </form>
                
                <div class="mt-4 text-sm text-gray-500 text-center">
                    Pertanyaan <?php echo $_SESSION['current_question'] + 1; ?> dari <?php echo count($questions); ?>
                </div>
            </div>
        <?php else: ?>
            <div>
                <h2 class="text-2xl font-bold mb-4">
                    <?php echo htmlspecialchars($resultDescriptions[$_SESSION['result']]['title']); ?>
                </h2>
                <p class="mb-6">
                    <?php echo htmlspecialchars($resultDescriptions[$_SESSION['result']]['description']); ?>
                </p>
                
                <form method="post">
                    <button 
                        type="submit" 
                        name="restart" 
                        class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600"
                    >
                        Mulai Ulang Tes
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
