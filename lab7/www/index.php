<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация питомца</title>
</head>
<body>
    <h1>Регистрация питомца</h1>
    
    <?php
    if (isset($_GET['message'])) {
        echo '<div class="message success">' . htmlspecialchars($_GET['message']) . '</div>';
    }
    if (isset($_GET['error'])) {
        echo '<div class="message error">' . htmlspecialchars($_GET['error']) . '</div>';
    }
    ?>

    <form action="send.php" method="POST">
        <div class="form-group">
            <label for="owner_name">Имя хозяина:</label>
            <input type="text" id="owner_name" name="owner_name" required>
        </div>

        <div class="form-group">
            <label for="pet_name">Имя питомца:</label>
            <input type="text" id="pet_name" name="pet_name" required>
        </div>

        <div class="form-group">
            <label for="pet_age">Возраст питомца:</label>
            <input type="number" id="pet_age" name="pet_age" min="0" max="50" required>
        </div>

        <div class="form-group">
            <label for="pet_type">Вид питомца:</label>
            <select id="pet_type" name="pet_type" required>
                <option value="">-- Выберите вид --</option>
                <option value="dog">Собака</option>
                <option value="cat">Кошка</option>
                <option value="bird">Птица</option>
                <option value="rodent">Грызун</option>
                <option value="reptile">Рептилия</option>
                <option value="other">Другое</option>
            </select>
        </div>

        <div class="form-group">
            <label>Прививки:</label>
            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="vaccinated" value="1"> 
                    Прививки есть
                </label>
            </div>
        </div>

        <div class="form-group">
            <label>Пол питомца:</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="pet_gender" value="male" required> 
                    Самец
                </label>
                <label>
                    <input type="radio" name="pet_gender" value="female"> 
                    Самка
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="notes">Дополнительная информация:</label>
            <textarea id="notes" name="notes" rows="3" placeholder="Особенности питомца, повадки и т.д."></textarea>
        </div>

        <button type="submit">Зарегистрировать питомца</button>
    </form>

    <div>
        <h3>Статистика регистраций</h3>
        <p>Зарегистрированные питомцы: 
            <?php
            if (file_exists('processed_pets.log')) {
                $lines = file('processed_pets.log');
                echo count($lines);
            } else {
                echo '0';
            }
            ?>
        </p>
        <p><a href="processed_pets.log" target="_blank">Посмотреть лог регистраций</a></p>
    </div>
</body>
</html>