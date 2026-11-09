<?php
require_once 'config.php';
require_once 'functions.php';
require_login();

$stmt = $pdo->prepare('SELECT * FROM student_biodata WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$biodata = $stmt->fetch();

$message = $_SESSION['flash_message'] ?? '';
unset($_SESSION['flash_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Biodata Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="page-wrap">
    <header class="topbar">
        <div>
            <p class="eyebrow">STUDENT PORTAL</p>
            <h1>Student Biodata Form</h1>
            <p class="muted">Welcome, <?= e($_SESSION['full_name']) ?></p>
        </div>
        <form method="POST" action="logout.php">
            <button class="button button-light" type="submit">Log out</button>
        </form>
    </header>

    <main class="form-card">
        <?php if ($message): ?><div class="alert success"><?= e($message) ?></div><?php endif; ?>
        <?php if (!empty($_GET['error'])): ?><div class="alert error"><?= e($_GET['error']) ?></div><?php endif; ?>

        <form id="biodataForm" method="POST" action="save_biodata.php">
            <div class="form-grid">
                <div class="field">
                    <label for="name">Full name</label>
                    <input id="name" name="full_name" type="text" value="<?= e($biodata['full_name'] ?? $_SESSION['full_name']) ?>" required>
                </div>
                <div class="field">
                    <label for="matric">Matric number</label>
                    <input id="matric" name="matric_number" type="text" value="<?= e($biodata['matric_number'] ?? '') ?>" required>
                </div>
                <div class="field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" value="<?= e($biodata['email'] ?? $_SESSION['email']) ?>" required>
                </div>
                <div class="field">
                    <label for="phone">Phone number</label>
                    <input id="phone" name="phone" type="tel" value="<?= e($biodata['phone'] ?? '') ?>" required>
                </div>
                <div class="field">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select gender</option>
                        <option value="Male" <?= (($biodata['gender'] ?? '') === 'Male') ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= (($biodata['gender'] ?? '') === 'Female') ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
                <div class="field">
                    <label for="department">Department</label>
                    <input id="department" name="department" type="text" value="<?= e($biodata['department'] ?? '') ?>" required>
                </div>
                <div class="field">
                    <label for="age">Age</label>
                    <input id="age" name="age" type="number" min="1" max="120" value="<?= e($biodata['age'] ?? '') ?>" required>
                </div>
            </div>
            <button type="submit" class="button">Save biodata</button>
            <p id="message" class="muted form-note">Your biodata will be saved to the database.</p>
        </form>
    </main>
</div>
</body>
</html>
