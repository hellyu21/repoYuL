<?php
ob_start();

require 'vendor/autoload.php';
require 'QueueManager.php';

try {
    $q = new QueueManager();
    $action = determineAction($_POST);
    $data = $_POST;
    $success = $q->publish($action, $data);
    ob_end_clean();
    if ($success) {
        header('Location: index.php?message=Запрос принят в обработку! Питомец будет зарегистрирован в течение нескольких секунд.');
        exit();
    } else {
        header('Location: index.php?error=Ошибка при отправке запроса');
        exit();
    }
    
} catch (Exception $e) {
    ob_end_clean();
    header('Location: index.php?error=' . urlencode($e->getMessage()));
    exit();
}

function determineAction($postData) {
    if (isset($postData['owner_name']) && isset($postData['pet_name']) && isset($postData['pet_type'])) {
        return 'add_pet';
    }
    
    return 'unknown_action';
}