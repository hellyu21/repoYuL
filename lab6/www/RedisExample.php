<?php

namespace App;

class RedisExample
{
    private $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('redis', 6379);
        $this->redis->ping();
    }

    public function setValue($key, $value)
    {
        return $this->redis->set($key, $value);
    }

    public function getValue($key)
    {
        return $this->redis->get($key);
    }

    public function deleteValue($key)
    {
        return $this->redis->del($key);
    }

    public function getAllKeys($pattern = '*')
    {
        return $this->redis->keys($pattern);
    }

    public function addToList($key, $value)
    {
        return $this->redis->rPush($key, $value);
    }

    public function getList($key)
    {
        return $this->redis->lRange($key, 0, -1);
    }

    public function removeFromList($key, $value)
    {
        return $this->redis->lRem($key, $value, 0);
    }
}