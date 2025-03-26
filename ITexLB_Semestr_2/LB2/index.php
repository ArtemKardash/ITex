<?php
    require 'vendor/autoload.php';

    $client = new MongoDB\Client("mongodb://root:root@mongo:27017");
    $db = $client->footballdb;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторна робота 2</title>

    <script>
        function saveToHistory(queryType, queryParams, queryResult) {
            let history = JSON.parse(localStorage.getItem('footballQueryHistory')) || [];
            
            history.unshift({
                type: queryType,
                params: queryParams,
                result: queryResult
            });
                
            localStorage.setItem('footballQueryHistory', JSON.stringify(history));
            
            displayHistory();
        }
        
        function displayHistory() {
            const historyContainer = document.getElementById('queryHistory');
            const history = JSON.parse(localStorage.getItem('footballQueryHistory')) || [];
            
            if (history.length === 0) {
                historyContainer.innerHTML = "<p style='font-size: 20px'>Історія запитів порожня</p>";
                return;
            }
            
            let html = '';
            history.forEach((item, index) => {
                html += `
                    <div class="history-item">
                        <div class="history-title">Запит ${index + 1}: ${getQueryTypeName(item.type)}</div>
                        <div class="history-title">Параметри: ${item.params}</div>
                        <div class="history-content">Результат:\n${item.result}</div>
                    </div>
                `;
            });
            
            historyContainer.innerHTML = html;
        }
        
        function clearHistory() {
            localStorage.removeItem('footballQueryHistory');
            displayHistory();
        }
        
        function getQueryTypeName(type) {
            const types = {
                'league_table': 'Таблиця чемпіонату',
                'players_list': 'Список гравців',
                'games_list': 'Список ігор'
            };
            return types[type] || type;
        }
        
        window.onload = displayHistory;
    </script>

    <style>
        .history-item {
            border: 1px solid;
            padding: 10px;
            margin-bottom: 10px;
        }
        .history-title {
            font-weight: bold;
        }
        .history-content {
            white-space: pre-wrap;
        }
    </style>

</head>
<body>

    <h1> Лабораторна робота 2, семестр 2<br>Кардаш Артем Євгенович<br>Варіант 7</h1>

    <h1> Завдання: Створити і заповнити БД футбольного чемпіонату. У базі представлено дві колекції - колекція документів, що описує команди (назва, тренер, склад команди (масив футболістів)), і колекція, яка містить документи, що описують ігри чемпіонату (ліга, дата і місце проведення, команди-учасниці гри, переможець тощо).
    Надати користувачеві можливість отримання такої інформації:<br>
    - таблиця чемпіонату для обраної ліги;<br>
    - список футболістів зазначеної команди;<br>
    - список ігор, у яких брала участь обрана команда.<br>
    </h1>

    <?php
        echo "<br><h2> Колекція документів, що описує команди (teams):</h2>";
        $teams = $db->teams->find()->toArray();

        foreach ($teams as $team) {
            echo "<p style='font-size: 20px'>Назва команди: " . $team['name'] . "<br>";
            echo "Тренер: " . $team['trainer'] . "<br>";
            
            if (isset($team['members'])) {
                if (is_object($team['members'])) { 
                    $team['members'] = (array) $team['members'];
                }
                if (is_array($team['members']) && count($team['members']) > 0) { 
                    echo "Гравці команди: " . implode(", ", $team['members']) . "<br>";
                } else {
                    echo "Гравці команди: помилка<br>";
                }
            } else {
                echo "Гравці команди: нема<br>";
            }
        }

            echo "<br><h2> Колекція, яка містить документи, що описують ігри чемпіонату (games):</h2>";
            $games = $db->games->find()->toArray();

            foreach ($games as $game) {
                echo "<p style='font-size: 20px'> Ліга: " . $game['League'] . "<br>";
                echo "Дата: " . date("Y-m-d H:i:s", $game['Data']) . "<br>";
                echo "Місце проведення: " . $game['Place'] . "<br>";

                if (isset($game['Players'])) {
                    if (is_object($game['Players'])) { 
                        $game['Players'] = (array) $game['Players'];
                    }
                    if (is_array($game['Players']) && count($game['Players']) > 0) { 
                        echo "Команди-учасники: " . implode(", ", $game['Players']) . "<br>";
                    } else {
                        echo "Команди-учасники: помилка<br>";
                    }
                } else {
                    echo "Команди-учасники: нема<br>";
                }

                echo "Переможець: " . $game['Winner'] . "<br>";
        }
    ?>

    <br><h2> Завдання 1: таблиця чемпіонату для обраної ліги</h2>

    <form method="POST" id="LeagueTable">
        <label style="font-size: 20px">Введіть назву ліги: </label>
        <input type="text" name="league_name" id="league_name" required>
        <button type="submit">Вивести таблицю</button>
    </form>

    <?php
        $gamesCollection = $db->games;
        $teamsCollection = $db->teams;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['league_name'])) {
            $leagueName = $_POST['league_name']; 

            $games = $gamesCollection->find(['League' => $leagueName]);

            $teamsStats = [];

            foreach ($games as $game) {
  
                $teams = $game['Players'];

                foreach ($teams as $team) {
                    if (!isset($teamsStats[$team])) {
                  
                        $teamsStats[$team] = [
                            'NameOfTeam' => $team,
                            'Games_played' => 0,
                            'Wins' => 0,
                            'Losses' => 0,
                        ];
                    }

                   
                    $teamsStats[$team]['Games_played']++;

                   
                    if ($game['Winner'] === $team) {
                     
                        $teamsStats[$team]['Wins']++;
                    } else {
                       
                        $teamsStats[$team]['Losses']++;
                    }
                }
            }

            if (empty($teamsStats)) {
                echo "<p style='font-size: 20px'>У лізі '{$leagueName}' немає ігор або лигу не знайдено.</p>";
            } else {
          
                usort($teamsStats, function ($teamA, $teamB) {
                    return $teamB['Wins'] - $teamA['Wins']; 
                });

                echo "<p style='font-size: 20px'>Таблиця для ліги: " . $leagueName . "</p>";
                echo "<table border='1' cellpadding='10'>";
                echo "<tr><th>Команда</th><th>Ігор</th><th>Перемог</th><th>Поразок</th><th>Позиція</th></tr>";
                
                $position = 1;
                foreach ($teamsStats as $teamName => $stats) {
                    echo "<tr>";
                    echo "<td>" . $stats['NameOfTeam'] . "</td>";
                    echo "<td>" . $stats['Games_played'] . "</td>";
                    echo "<td>" . $stats['Wins'] . "</td>";
                    echo "<td>" . $stats['Losses'] . "</td>";
                    echo "<td>" . $position . "</td>";
                    echo "</tr>";
                    $position++;
                }
                echo "</table>";

                $result = "Таблиця для ліги " . $leagueName . ":\n\n";
                $position = 1;
                foreach ($teamsStats as $teamName => $stats) {
                    $result .= "Команда: " . $stats['NameOfTeam'] . "\tИгор: " . $stats['Games_played'] . "\tПеремог: " . 
                            $stats['Wins'] . "\tПоразок: " . $stats['Losses'] . "\tПозиція: " . $position . "\n";
                    $position++;
                }
                
                echo "<script>saveToHistory('league_table', '" . $leagueName . "', " . json_encode($result) . ");</script>";
            }
        }
    ?>

    <br><h2> Завдання 2: список футболістів зазначеної команди</h2>

    <form method="POST" id="PlayersList">
        <label style='font-size: 20px'> Введіть назву команди: </label>
        <input type="text" name="players_list" id="players_list" required>
        <button type="submit">Вивести список гравців</button>
    </form>

    <?php
       $teamsCollection = $db->teams;

       if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['players_list'])) {
           $TeamName = $_POST['players_list'];
   
           $SelectedTeam = $teamsCollection->findOne(['name' => $TeamName]);
   
           if ($SelectedTeam) {
               echo "<p style='font-size: 20px'>Список гравців команди " . $SelectedTeam['name'] . ":</p>";
               echo "<ul style='font-size: 20px'>";
               foreach ($SelectedTeam['members'] as $member) {
                   echo "<li>" . $member . "</li>";
               }
               echo "</ul>";

               $result = "Список гравців команди " . $SelectedTeam['name'] . ":\n\n";
               $result .= implode("\n", (array) $SelectedTeam['members']);

               echo "<script>saveToHistory('players_list', '" . $TeamName . "', " . json_encode($result) . ");</script>";
           } else {
               echo "<p style='font-size: 20px'>Команду з назвою '{$TeamName}' не знайдено.</p>";
           }
       }
    ?>

    <br><h2> Завдання 3: список ігор, у яких брала участь обрана команда</h2>

    <form method="POST" id="GamesList">
        <label style='font-size: 20px'>Введіть назву команди: </label>
        <input type="text" name="team_name" id="team_name" required>
        <button type="submit">Вивести список ігор</button>
    </form>

    <?php
        $gamesCollection = $db->games;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['team_name'])) {
            $TeamName2 = $_POST['team_name'];  

            $games = $gamesCollection->find(['Players' => $TeamName2]);  

            if ($games->isDead()) {        
                echo "<p style='font-size: 20px'>Команда '$TeamName2' не брала участь у жодній грі.</p>";
            } else {
                echo "<p style='font-size: 20px'>Список ігор для команди " . $TeamName2 . ":</p>";
                echo "<ul style='font-size: 20px'>";

                $result = "Список ігор для команди " . $TeamName2 . ":\n";
                foreach ($games as $game) {
                    echo "<li>Ліга: " . $game['League'] . "<br>";
                    echo "Дата: " . date("Y-m-d H:i:s", $game['Data']) . "<br>";
                    echo "Місце проведення: " . $game['Place'] . "<br><br>";

                    $result .= "\nЛіга: " . $game['League'] . "\n";
                    $result .= "Дата: " . date("Y-m-d H:i:s", $game['Data']) . "\n";
                    $result .= "Місце проведення: " . $game['Place'] . "\n";
                }
                echo "</ul>";

                echo "<script>saveToHistory('games_list', '" . $TeamName2 . "', " . json_encode($result) . ");</script>";
            }
        }
    ?>
    
    <br><h2>Історія запитів</h2>
    
    <div id="queryHistory">
        <p style='font-size: 20px'></p>
    </div>

    <button class="clear-history" onclick="clearHistory()">Очистити історію</button>

</body>
</html>
