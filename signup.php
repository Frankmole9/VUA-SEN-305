<?php
require_once 'config.php';
require_once 'functions.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$fullName = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($fullName === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Please complete all fields with valid information.';
    } elseif ($password !== $confirmPassword) {
        $error = 'The passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must contain at least 6 characters.';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)');
            $stmt->execute([$fullName, $email, password_hash($password, PASSWORD_DEFAULT)]);
            header('Location: login.php?created=1');
            exit;
        } catch (PDOException $ex) {
            if ($ex->getCode() === '23000') {
                $error = 'An account with that email already exists.';
            } else {
                $error = 'Could not create your account. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Student Biodata</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<main class="auth-card">
    <p class="eyebrow">STUDENT PORTAL</p>
    <h1>Create your account</h1>
    <p class="muted">Sign up to submit and manage your student biodata.</p>

    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>

    <form method="POST" action="signup.php">
        <label for="full_name">Full name</label>
        <input id="full_name" name="full_name" type="text" value="<?= e($fullName) ?>" required>

        <label for="email">Email address</label>
        <input id="email" name="email" type="email" value="<?= e($email) ?>" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" minlength="6" required>

        <label for="confirm_password">Confirm password</label>
        <input id="confirm_password" name="confirm_password" type="password" minlength="6" required>

        <button type="submit" class="button">Create account</button>
    </form>
    <p class="switch-link">Already registered? <a href="login.php">Log in</a></p>
</main>
</body>
</html>
