<?php
if (!is_dir('/tmp/kfi_sessions')) {
    mkdir('/tmp/kfi_sessions', 0775, true);
}
session_save_path('/tmp/kfi_sessions');
session_start();

if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $username = trim($_POST['user'] ?? '');
    $password = $_POST['pass'] ?? '';

    if ($username === 'admin' && $password === 'kfi2024') {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    }

    $error = 'Invalid username or password.';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KFI Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-auth-page">
    <main class="admin-auth-shell">
        <section class="admin-auth-card">
            <div class="text-center mb-4">
                <img src="../assets/images/logo.png" width="70" height="70" alt="KFI logo">
                <h1>KFI Admin</h1>
                <p>Sign in to publish school news and updates.</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger small"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="user" class="form-label">Username</label>
                    <input type="text" name="user" id="user" class="form-control" autocomplete="username" required>
                </div>
                <div class="mb-4">
                    <label for="pass" class="form-label">Password</label>
                    <input type="password" name="pass" id="pass" class="form-control" autocomplete="current-password" required>
                </div>
                <button type="submit" class="btn btn-school w-100">Login</button>
                <a href="../index.php" class="admin-back-link">Back to website</a>
            </form>
        </section>
    </main>
</body>
</html>
