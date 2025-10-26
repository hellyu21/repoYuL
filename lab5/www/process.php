<?php
session_start();
require_once 'ApiClient.php';

$username = htmlspecialchars($_POST['username']);
$email = htmlspecialchars($_POST['email'] ?? '');
$api = new ApiClient();
$url = 'https://dummyjson.com/products/category/furniture';
$apiData = $api->request($url);


$_SESSION['username'] = $username;
$_SESSION['email'] = $email;

$_SESSION['api_data'] = $apiData;

$errors = [];
if(empty($username)) $errors[] = "Имя не может быть пустым";
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Некорректный email";

if(!empty($errors)){
    $_SESSION['errors'] = $errors;
    header("Location: index.php");
    exit();
}

setcookie("last_submission", date('Y-m-d H:i:s'), time() + 3600, "/");

header("Location: index.php");
$line = $username . ";" . $email . "\n";
file_put_contents("data.txt", $line, FILE_APPEND);
exit();