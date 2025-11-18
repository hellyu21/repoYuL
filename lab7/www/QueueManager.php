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
    }
}