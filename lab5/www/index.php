<?php
require 'db.php';
require 'Pet.php';

$pet = new Pet($pdo);
$all = $pet->getAll();
?>
<h2>Сохранённые данные:</h2>
<ul>
<?php foreach($all as $row): ?>
    <li><?= $row['owner_name'] ?>, <?= $row['pet_age'] ?> лет, <?= $row['pet_type'] ?>, Вакцинация: <?= $row['has_vaccinations'] ? 'Да' : 'Нет' ?>, Пол: <?= $row['pet_gender ']?></li>
<?php endforeach; ?>
</ul>

<a href="form.html">Заполнить форму</a>
