<?php
require 'db.php';
require 'Pet.php';

$pet = new Pet($pdo);

$owner_name = htmlspecialchars($_POST['owner_name']);
$pet_age = intval($_POST['pet_age']);
$pet_type = htmlspecialchars($_POST['pet_type'] ?? '');
$has_vaccinations = isset($_POST['has_vaccinations']) ? 1 : 0;
$pet_gender = $_POST['pet_gender'] ?? '';

$pet->add($owner_name, $pet_age, $pet_type, $has_vaccinations, $pet_gender);

header("Location: index.php");
exit();
