<?php session_start(); ?>
<?php require_once 'UserInfo.php'; ?>

<?php $info = UserInfo::getInfo(); ?>
<h3>Информация о пользователе:</h3>
<?php foreach ($info as $key => $val): ?>
    <?= htmlspecialchars($key) ?> : <?= htmlspecialchars($val) ?><br>
<?php endforeach; ?>

<?php if(isset($_SESSION['username'])): ?>
    <p>Данные из сессии:</p>
    <ul>
        <li>Имя: <?= $_SESSION['username'] ?></li>
        <li>Email: <?= $_SESSION['email'] ?></li>
    </ul>
<?php else: ?>
    <p>Данных пока нет.</p>
<?php endif; ?>

<?php if(isset($_SESSION['errors'])): ?>
    <ul style="color:red;">
        <?php foreach($_SESSION['errors'] as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['api_data'])): ?>
    <h3>Данные из API:</h3>
    <pre><?php print_r($_SESSION['api_data']); ?></pre>
    
<?php endif; ?>

<a href="form.html">Заполнить форму</a>
<a href="view.php">Посмотреть все данные</a>