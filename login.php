<?php
require_once 'config.php';
require_once 'functions.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT id, full_name, email, password FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email'] = $user['email'];
        header('Location: index.php');
        exit;
    }

    $error = 'Incorrect email or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Student Biodata</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<main class="auth-card">
    <p class="eyebrow">STUDENT PORTAL</p>
    <h1>Welcome back</h1>
    <p class="muted">Log in to continue to your biodata form.</p>

    <?php if (isset($_GET['created'])): ?><div class="alert success">Account created successfully. You can now log in.</div><?php endif; ?>
    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>

    <form method="POST" action="login.php">
        <label for="email">Email address</label>
        <input id="email" name="email" type="email" value="<?= e($email) ?>" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <button type="submit" class="button">Log in</button>
    </form>
    <p class="switch-link">Don't have an account? <a href="signup.php">Sign up</a></p>
</main>
</body>
</html>
