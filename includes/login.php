<?php
session_start();
if (isset($_POST['login'])) {
    // Simple hardcoded credentials (change these!)
    if ($_POST['user'] === 'admin' && $_POST['pass'] === 'kfi2024') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    }
    $error = "Invalid credentials";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - KFI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #000039; display: flex; align-items: center; justify-content: center; height: 100vh; color: white; }
        .login-card { background: white; padding: 2rem; border-radius: 12px; color: #333; width: 100%; max-width: 400px; }
    </style>
</head>
<body>
    <div class="login-card shadow">
        <div class="text-center mb-4">
            <img src="../assets/images/logo.png" width="60" alt="Logo">
            <h4 class="mt-2 fw-bold">KFI Admin</h4>
        </div>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger small"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold">Username</label>
                <input type="text" name="user" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Password</label>
                <input type="password" name="pass" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100 fw-bold" style="background:#00008E">Login</button>
            <div class="text-center mt-3">
                <a href="../index.php" class="text-muted small text-decoration-none">← Back to website</a>
            </div>
        </form>
    </div>
</body>
</html>