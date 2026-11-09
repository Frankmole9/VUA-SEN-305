<?php
require_once 'config.php';
require_once 'functions.php';
require_login();

$fullName = trim($_POST['full_name'] ?? '');
$matricNumber = trim($_POST['matric_number'] ?? '');
$email = strtolower(trim($_POST['email'] ?? ''));
$phone = trim($_POST['phone'] ?? '');
$gender = $_POST['gender'] ?? '';
$department = trim($_POST['department'] ?? '');
$age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);

if (
    $fullName === '' || $matricNumber === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    $phone === '' || !in_array($gender, ['Male', 'Female'], true) ||
    $department === '' || !$age || $age < 1 || $age > 120
) {
    header('Location: index.php?error=' . urlencode('Please complete every field with valid information.'));
    exit;
}

$sql = 'INSERT INTO student_biodata
        (user_id, full_name, matric_number, email, phone, gender, department, age)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
        full_name = VALUES(full_name),
        matric_number = VALUES(matric_number),
        email = VALUES(email),
        phone = VALUES(phone),
        gender = VALUES(gender),
        department = VALUES(department),
        age = VALUES(age)';

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_SESSION['user_id'], $fullName, $matricNumber, $email,
    $phone, $gender, $department, $age
]);

$_SESSION['flash_message'] = 'Your biodata has been saved successfully.';
header('Location: index.php');
exit;
