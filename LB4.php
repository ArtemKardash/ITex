<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторна робота 4</title>
</head>
<body>

    <h1> Лабораторна робота 4<br>Кардаш Артем Євгенович<br>Варіант 7</h1>

    <h1> Завдання: Створити два довільні цілочисленні масиви. Написати сценарій, який:<br>
       1. прибирає всі елементи, що дублюються, з кожного масиву;<br>
       2. виводить кількість дублюючих елементів двох масивів;<br>
       3. зливає два масиви в один, прибираючи всі значення, що дублюються;<br>
       4. змінює місцями значення масиву (перший елемент масиву стає останнім, передостанній – другим, …, останній першим). Використовувати для цього цикл foreach (замість вже наявної функції reverse).
    </h1>

    <?php

        function DeleteItems(&$array){

            $remove = array();
    
            for ($i = 0; $i < count($array); $i++) {
                for ($j = $i + 1; $j < count($array); $j++) {
                    if ($array[$i] == $array[$j]) {
                        $remove[] = $j;
                    }
                }
            }
    
            foreach($remove as $i){
                unset($array[$i]);
            }

            $array = array_values($array);

            return $array;
        }
        
        $array1 = array(-5, 1, 9, 5, 0, 9, 0, -5, 12, 9, 12);
        $array2 = array(0, -1, 9, -1, -11, 15, 4, 9, -11, 0, -1);

        echo("<h1>Масив 1: </h1>");
        echo "<pre>";
        print_r($array1);
        echo "</pre>";

        echo("<h1>Масив 2: </h1>");
        echo "<pre>";
        print_r($array2);
        echo "</pre>";

        echo("<h1>Завдання 1: прибрати всі елементи, що дублюються, з кожного масиву.</h1>");

        DeleteItems($array1);
        DeleteItems($array2);
        

        echo "<pre>";
        print_r($array1);
        print_r($array2);
        echo "</pre>";

        echo("<h1>Завдання 2: вивести кількість дублюючих елементів двох масивів.</h1>");

        $count = 0;
        $equalElem = array();

        foreach($array1 as $i){
            $equal = false;
            foreach($array2 as $j){
                if($i == $j){
                    $equal = true;
                    $equalElem[] = $i;
                    break;
                }
            }

            if ($equal) {
                $count++;
            }
        }

        echo "<span>Однакових елементів: $count</span>";
        echo "<pre>";
        print_r($equalElem);
        echo "</pre>";

        echo("<h1>Завдання 3: злити два масиви в один, прибираючи всі значення, що дублюються.</h1>");

        foreach($array2 as $i){
            $equal = false;
            foreach($array1 as $j){
                if($i == $j){
                    $equal = true;
                    break;
                }
            }

            if (!$equal) {
                $array1[] = $i;
            }
        }

        echo "<pre>";
        print_r($array1);
        echo "</pre>";

        echo("<h1>Завдання 4: змінити місцями значення масиву.</h1>");

        $left = 0;
        $right = count($array1) - 1;

        foreach ($array1 as $index => $value) {
         
            $temp = $array1[$index];
            $array1[$index] = $array1[$right];
            $array1[$right] = $temp;
            
            $left++;

            if ($left == $right){
                break; 
            }

            $right--;
        }

        echo "<pre>";
        print_r($array1);
        echo "</pre>";

        /*$temp = "text.txt";

        if(file_exists($temp)){
            $file = fopen($temp, "r");
            $counter = (int)fread($file, filesize($temp));
            fclose($file);
        } else {
            $counter= 0;
        }
        $counter++;
        $file = fopen($temp, "w");
        fwrite($file, $counter);
        fclose($file);
        echo "Кількість заходжень на сторінку: $counter"*/
    ?>
    
</body>
</html>