<?php
require 'vendor/autoload.php';
require 'QueueManager.php';
require 'ActionHandler.php';

sleep(10);

$q = new QueueManager();
$handler = new ActionHandler();

echo "👷 Worker запущен и ожидает сообщения...\n";
echo "📝 Топик: lab7_topic\n";
echo "🌐 Kafka: kafka:9092\n\n";

try {
    $q->consume(function($message) use ($handler) {
        return $handler->handle($message);
    });
} catch (Exception $e) {
    echo "❌ Критическая ошибка worker: " . $e->getMessage() . "\n";
    sleep(5);
    exit(1);
}