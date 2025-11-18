<?php
require_once 'vendor/autoload.php';

use RdKafka\Conf;
use RdKafka\Producer;
use RdKafka\KafkaConsumer;
use RdKafka\Message;

class QueueManager {
    private $topic = 'lab7_topic';
    private $brokerList = 'kafka:9092';
    public function __construct() {
        $this->waitForKafka();
    }

    private function waitForKafka($maxAttempts = 30) {
        $attempt = 0;
        while ($attempt < $maxAttempts) {
            try {
                $socket = @fsockopen('kafka', 9092, $errno, $errstr, 1);
                if ($socket) {
                    fclose($socket);
                    return true;
                }
            } catch (Exception $e) {
            }
            $attempt++;
            sleep(1);
        }
        throw new Exception("Kafka не доступен после $maxAttempts попыток");
    }

    public function publish($action, $data) {
        try {
            $conf = new Conf();
            $conf->set('metadata.broker.list', $this->brokerList);
            
            $producer = new Producer($conf);
            $topic = $producer->newTopic($this->topic);

            // Формируем сообщение
            $message = [
                'action' => $action,
                'data' => $data,
                'timestamp' => date('Y-m-d H:i:s'),
                'id' => uniqid()
            ];

            $payload = json_encode($message);
            
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload, $action);
            
            $producer->poll(0);
            
            $result = $producer->flush(10000);
            
            if (RD_KAFKA_RESP_ERR_NO_ERROR === $result) {
                error_log("✅ Сообщение отправлено в Kafka: " . $payload);
                return true;
            } else {
                error_log("❌ Ошибка отправки в Kafka: код $result");
                return false;
            }
            
        } catch (Exception $e) {
            error_log("❌ Ошибка отправки в Kafka: " . $e->getMessage());
            return false;
        }
    }

    public function consume(callable $callback) {
        try {
            $conf = new Conf();
            $conf->set('group.id', 'lab7_group');
            $conf->set('metadata.broker.list', $this->brokerList);
            $conf->set('auto.offset.reset', 'earliest');
            $conf->set('enable.auto.commit', 'false');

            $consumer = new KafkaConsumer($conf);
            $consumer->subscribe([$this->topic]);

            echo "👷 Consumer запущен. Ожидание сообщений...\n";
            while (true) {
                $message = $consumer->consume(120 * 1000); // 120 секунд таймаут
                
                switch ($message->err) {
                    case RD_KAFKA_RESP_ERR_NO_ERROR:
                        try {
                            $data = json_decode($message->payload, true);
                            echo "📥 Получено сообщение: " . $message->payload . "\n";
                            
                            $result = $callback($data);
                            
                            if ($result) {
                                echo "✅ Обработано: {$data['action']}\n";
                            } else {
                                echo "❌ Ошибка обработки: {$data['action']}\n";
                            }
                            
                            $consumer->commit($message);
                            
                        } catch (Exception $e) {
                            echo "❌ Ошибка обработки сообщения: " . $e->getMessage() . "\n";
                        }
                        break;
                        
                    case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                        echo "ℹ️  Достигнут конец раздела\n";
                        break;
                        
                    case RD_KAFKA_RESP_ERR__TIMED_OUT:
                        echo "⏰ Таймаут ожидания сообщений\n";
                        break;
                        
                    default:
                        echo "❌ Ошибка Kafka: " . $message->errstr() . "\n";
                        break;
                }
                
                usleep(100000); // 100ms
            }
            
        } catch (Exception $e) {
            echo "❌ Критическая ошибка consumer: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}