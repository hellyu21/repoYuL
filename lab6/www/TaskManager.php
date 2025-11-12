<?php

namespace App;

class TaskManager
{
    private $redis;

    public function __construct()
    {
        $this->redis = new RedisExample();
    }

    public function addTask($text)
    {
        $taskId = uniqid();
        $task = [
            'id' => $taskId,
            'text' => $text,
            'created_at' => date('Y-m-d H:i:s'),
            'completed' => false
        ];
        
        $this->redis->setValue("task:$taskId", json_encode($task));
        
        $taskIds = $this->getTaskIds();
        $taskIds[] = $taskId;
        $this->redis->setValue('task_ids', json_encode(array_values($taskIds)));
        
        return $taskId;
    }

    public function deleteTask($taskId)
    {
        $this->redis->deleteValue("task:$taskId");
        
        $taskIds = $this->getTaskIds();
        $taskIds = array_filter($taskIds, function($id) use ($taskId) {
            return $id !== $taskId;
        });
        $this->redis->setValue('task_ids', json_encode(array_values($taskIds)));
    }

    public function toggleTask($taskId)
    {
        $taskData = $this->redis->getValue("task:$taskId");
        if ($taskData) {
            $task = json_decode($taskData, true);
            $task['completed'] = !$task['completed'];
            $this->redis->setValue("task:$taskId", json_encode($task));
            return true;
        }
        return false;
    }

    public function getAllTasks()
    {
        $tasks = [];
        $taskIds = $this->getTaskIds();
        
        foreach ($taskIds as $taskId) {
            $taskData = $this->redis->getValue("task:$taskId");
            if ($taskData) {
                $task = json_decode($taskData, true);
                if ($task && isset($task['text'])) {
                    $tasks[] = $task;
                }
            }
        }

        usort($tasks, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        return $tasks;
    }

    private function getTaskIds()
    {
        $taskIds = $this->redis->getValue('task_ids');
        return $taskIds ? json_decode($taskIds, true) : [];
    }
}