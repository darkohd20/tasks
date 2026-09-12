<?php

session_start();

require 'connection.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

if ($name === '' || $email === '' || $password === '' || $password_confirm === '') {
    $_SESSION['toast'] = 'Todos los campos son obligatorios.';
    $_SESSION['toast_type'] = 'error';
    header('Location: ../views/register.php');
    exit;
}

if ($password !== $password_confirm) {
    $_SESSION['toast'] = 'Las contraseñas no coinciden.';
    $_SESSION['toast_type'] = 'error';
    header('Location: ../views/register.php');
    exit;
}

$stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {
    $stmt->close();

    $_SESSION['toast'] = 'El email ya está registrado.';
    $_SESSION['toast_type'] = 'error';
    header('Location: ../views/register.php');
    exit;
}

$stmt->close();

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    'INSERT INTO users (name, email, password) VALUES (?, ?, ?)'
);
$stmt->bind_param('sss', $name, $email, $password_hash);

if ($stmt->execute()) {
    $_SESSION['toast'] = 'Usuario registrado correctamente. Inicia sesión.';
    $_SESSION['toast_type'] = 'success';
    header('Location: ../index.php');
} else {
    $_SESSION['toast'] = 'No se pudo registrar el usuario.';
    $_SESSION['toast_type'] = 'error';
    header('Location: ../views/register.php');
}

$stmt->close();
exit;