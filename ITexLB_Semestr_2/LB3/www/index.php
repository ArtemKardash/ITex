<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторна робота 3</title>
</head>
<body>
    <h1> Лабораторна робота 3, семестр 2<br>Кардаш Артем Євгенович<br>Варіант 7</h1>
    <h1> Завдання PDO: БД для зберігання інформації провайдеру про використання мережевого трафіку.<br>
    Забезпечити виведення таких даних:<br>
    - сеанси роботи в мережі для обраного клієнта;<br>
    - сеанси роботи в мережі за вказаний проміжок часу;<br>
    - список клієнтів з від'ємним балансом рахунку.<br>
    <br>
    Завдання AJAX: Додати на стартову сторінку код, що використовує XMLHttpRequest для відправки запиту до обробників. Змінити код обробників запитів від клієнту таким чином, щоб виведення результату користувачеві не призводило до перезавантаження сторінки - тобто, використовувати технологію Ajax. Використовувати такі формати відповіді від сервера:<br>
    - у форматі простого тексту (безпосередньо отримувати на клієнті згенерований фрагмент HTML-коду та виводити його в заданому елементі стартової сторінки);<br>
    - у форматі XML (результат запиту на вибірку міститься у генерованій сервером XML-відповіді, яку клієнт зчитує через властивість responseXml і формує висновок користувачеві);<br>
    - в формате JSON (результат запиту на вибірку поміщається в масив, який потім перетворюється на JSON-рядок за допомогою методу json_encode і відправляється клієнту, який отримує дані вибірки з рядка за допомогою методу JSON.parse і формує виведення користувачеві).<br>
    </h1>

    <?php
        echo "<p style='font-size: 20px'><b> Підключення до бази даних: </b></p>";
        require "Connection.php"; 
        echo "<p style='font-size: 20px'><b> Connected to database<br> </b></p>";
    ?>

    <br><h2> Завдання 1: сеанси роботи в мережі для обраного клієнта</h2>
    <form>
        <label style='font-size: 20px'> Оберіть клієнта: </label>
        <select id="ClientSeanseSelect" name="Client" required>
            <?php
            $list = $dbh->query("SELECT name FROM client");
             while ($client = $list->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$client['name']}'>{$client['name']}</option>";
            }
            ?>
        </select>
        <input id="buttonSelectClient" type="button" value="Вивести сеанси"></input>
    </form>

    <div id="SeanseClientResult"></div>

    <br><h2> Завдання 2: сеанси роботи в мережі за вказаний проміжок часу</h2>
    <form>
        <label style='font-size: 20px'>Напишіть проміжок часу: з </label>
        <input type="time" id="ClientTime_One" name="time" required>
        <label style='font-size: 20px'> по </label>
        <input type="time" id="ClientTime_Two" name="time2" required>
        <input id="buttonClientTime" type="button" value="Вивести сеанси"></input>
    </form>

    <div id="SeanseTimeResult"></div>

    <br><h2> Завдання 3: список клієнтів з від'ємним балансом рахунку</h2>
    <form>
    <input id="buttonBalance" type="button" value="Вивести клієнтів з від'ємним балансом рахунку"></input>
    </form>

    <div id="SeanseClientBalance"></div>

    <script src="AJAXMethod.js"></script>
</body>
</html>