<?php
require 'vendor/autoload.php';

use App\TaskManager;

session_start();

try {
    $taskManager = new TaskManager();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

if (isset($_POST['action']) && $_POST['action'] === 'add_task' && !empty($_POST['task'])) {
    $taskManager->addTask(htmlspecialchars($_POST['task']));
    $_SESSION['message'] = "Task added successfully!";
    header("Location: /");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && !empty($_GET['id'])) {
    $taskManager->deleteTask($_GET['id']);
    $_SESSION['message'] = "Task deleted!";
    header("Location: /");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'toggle' && !empty($_GET['id'])) {
    $taskManager->toggleTask($_GET['id']);
    header("Location: /");
    exit;
}

$tasks = $taskManager->getAllTasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Tracker</title>
</head>
<body>
    <div class="container">
        <h1>Task Tracker</h1>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?= $_SESSION['message'] ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <form method="POST" class="form-group">
            <input type="hidden" name="action" value="add_task">
            <input type="text" name="task" placeholder="Enter new task..." required>
            <button type="submit" style="margin-top: 10px; width: 100px;">Add Task</button>
        </form>
        <ul class="task-list">
            <?php if (empty($tasks)): ?>
                <li class="no-tasks">No tasks yet. Add your first task!</li>
            <?php else: ?>
                <?php foreach ($tasks as $task): ?>
                    <li class="task-item <?= $task['completed'] ? 'completed' : '' ?>">
                        <div class="task-text">
                            <?= $task['text'] ?>
                                Created: <?= $task['created_at'] ?>
                        </div>
                        <div class="task-actions">
                            <a href="?action=toggle&id=<?= $task['id'] ?>" class="btn btn-toggle">
                                <?= $task['completed'] ? 'Undo' : 'Done' ?>
                            </a>
                            <a href="?action=delete&id=<?= $task['id'] ?>" class="btn btn-delete">Delete</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>