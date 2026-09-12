<?php

session_start();

require 'connection.php';

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    $_SESSION['toast'] = 'Email y contraseña son obligatorios.';
    $_SESSION['toast_type'] = 'error';
    header('Location: ../index.php');
    exit;
}

$stmt = $conn->prepare(
    'SELECT id, name, email, password FROM users WHERE email = ?'
);
$stmt->bind_param('s', $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();

if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['toast'] = 'Email o contraseña incorrectos.';
    $_SESSION['toast_type'] = 'error';
    header('Location: ../index.php');
    exit;
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_email'] = $user['email'];

$_SESSION['toast'] = 'Bienvenido ' . htmlspecialchars($user['name']);
$_SESSION['toast_type'] = 'success';

header('Location: ../views/tasks.php');
exit;