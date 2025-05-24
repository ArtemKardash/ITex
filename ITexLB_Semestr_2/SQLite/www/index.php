<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторна робота 1</title>
</head>
<body>

    <h1> Лабораторна робота 1, семестр 2<br>Кардаш Артем Євгенович<br>Варіант 7</h1>

    <h1> Завдання: БД для зберігання інформації провайдеру про використання мережевого трафіку.<br>
    Забезпечити виведення таких даних:<br>
    - сеанси роботи в мережі для обраного клієнта;<br>
    - сеанси роботи в мережі за вказаний проміжок часу;<br>
    - список клієнтів з від'ємним балансом рахунку.<br>
    </h1>

    <?php
        echo "<p style='font-size: 20px'><b> Підключення до бази даних: </b></p>";
        require "Connection.php"; 
    ?>

    <br><h2> Завдання 1: сеанси роботи в мережі для обраного клієнта</h2>

    <form action="SeanseClient.php" method="POST">
        <label style='font-size: 20px'> Оберіть клієнта: </label>
        <select name="Client" required>
            <?php
            $list = $dbh->query("SELECT name FROM client");
             while ($client = $list->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$client['name']}'>{$client['name']}</option>";
            }
            ?>
        </select>
        <button type="submit"> Вивести сеанси </button>
    </form>

    <br><h2> Завдання 2: сеанси роботи в мережі за вказаний проміжок часу</h2>
    <form action="SeanseTime.php" method="POST">
        <label style='font-size: 20px'>Напишіть проміжок часу: з </label>
        <input type="time" name="time" required>
        <label style='font-size: 20px'> по </label>
        <input type="time" name="time2" required>
        <button type="submit">Вивести сеанси</button>
    </form>

    <br><h2> Завдання 3: список клієнтів з від'ємним балансом рахунку</h2>
    <form action="NegativeBalance.php" method="POST">
        <button type="submit">Вивести клієнтів з від'ємним балансом рахунку </button>
    </form>

    <br><h2> ІДЗ: SQLite</h2>
    <form action="DBCreate.php" method="POST">
        <button type="submit">Створити БД </button>
    </form>
    <br>
    <form action="View.php" method="POST">
        <button type="submit">Вивести логування </button>
    </form>

</body>
</html>