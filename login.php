<?php
require __DIR__ . '/config/database.php';
// Kalau sudah login, tidak perlu melihat halaman login lagi
if (!empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit;
    }
    $error = 'Username atau password salah.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Siswa</title>
    <style>
    * { 
        box-sizing: border-box; 
        margin: 0;
        padding: 0;
    }

    body {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: linear-gradient(135deg, #08dffc 0%, #2563eb 100%);
        font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
    }

    .login-card {
        width: 100%;
        max-width: 400px;
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(10px);
        padding: 36px 32px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.6);
        transition: transform 0.3s ease;
    }

    .login-card h1 {
        text-align: center;
        font-size: 24px;
        font-weight: 700;
        letter-spacing: -0.5px;
        background: linear-gradient(90deg, #e00fb3, #2563eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .login-card .sub {
        text-align: center;
        margin: 6px 0 28px;
        font-size: 14px;
        color: #4b5563;
    }

    .login-card label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 6px;
    }

    .login-card input {
        width: 100%;
        padding: 12px 14px;
        margin-bottom: 18px;
        background: #f9fafb;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        color: #111827;
        transition: all 0.25s ease;
    }

    .login-card input:focus {
        outline: none;
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
    }

    .login-card button {
        width: 100%;
        padding: 13px;
        margin-top: 4px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        transition: all 0.25s ease;
    }

    .login-card button:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #e00fb3 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(224, 15, 179, 0.35);
    }

    .login-card button:active {
        transform: translateY(0);
    }

    .error {
        background: #fef2f2;
        color: #b91c1c;
        border-left: 4px solid #ef4444;
        border-top: 1px solid #fecaca;
        border-right: 1px solid #fecaca;
        border-bottom: 1px solid #fecaca;
        padding: 12px 14px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 13px;
        font-weight: 500;
    }
</style>

</head>
<body>
<div class="login-card">
    <h1>SMK MIFTAHUL KHOIR</h1>
    <p class="sub">Login Manajemen Siswa</p>
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required autofocus>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Masuk</button>
    </form>
</div>
</body>
</html>