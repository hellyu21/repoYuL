<?php
session_start();

$username = htmlspecialchars($_POST['username']);
$model = htmlspecialchars($_POST['model'] ?? '');

$_SESSION['username'] = $username;
$_SESSION['model'] = $model;

header("Location: index.php");
exit();
