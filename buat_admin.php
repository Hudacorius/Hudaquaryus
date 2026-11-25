<?php
require __DIR__ . '/config/database.php';
$jumlah = (int) $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
if ($jumlah > 0) {
    echo "Akun admin sudah ada. Hapus file buat_admin.php ini.";
    exit;
}
$pesan = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || strlen($password) < 6) {
        $pesan = 'Username wajib diisi dan password minimal 6 karakter.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->execute([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
        echo "Akun berhasil dibuat. <a href='login.php'>Ke halaman login</a>. Setelah itu HAPUS file buat_admin.php.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Admin</title>
</head>
<body>
    <h1>Buat Akun Admin</h1>

    <?php if ($pesan): ?>
        <p style="color:red;"><?= htmlspecialchars($pesan) ?></p>
    <?php endif; ?>

    <form method="POST">
        <p>Username: <input type="text" name="username" required></p>
        <p>Password: <input type="password" name="password" required></p>
        <button type="submit">Buat Akun</button>
    </form>
</body>
</html>