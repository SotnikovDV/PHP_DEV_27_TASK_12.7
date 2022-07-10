<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>PHP_DEV_27_TASK_12.7</title>
</head>

<body>
    <header>
        <table>
            <h2>Практическое задание на тему "Строки и массивы в PHP"</h2>
            <tr>
                <td>Группа:</td>
                <td>PHP_DEV_27</td>
            </tr>
            <tr>
                <td>Слушатель:</td>
                <td>Сотников Д.В.</td>
            </tr>
            <tr>
                <td>Задание:</td>
                <td>12.7</td>
            </tr>
        </table>
        <hr>
    </header>
    <main>

        <?php
        require 'php/persons_array.php';
        require 'php/func.php';

        echo ('<h3>Массив клиентов:</h3>');
        echo ('<table><tr><th>№№</th><th>ФИО</th><th>Предпочтитаемый пол</th><th>Имя Ф.</th><th>Должность</th><tr>');

        // выводим массив с доп.информацией в таблицу на странице
        foreach ($example_persons_array as $key => $value) {

            // массив с частями ФИО
            $fio = getPartsFromFullname($value['fullname']);
            // пол
            $gender = getGenderFromName($value['fullname']);

            echo ('<tr><td align="center">' . $key . '</td><td>' . getFullnameFromParts($fio['surname'], $fio['name'], $fio['patronomyc']) . '</td>');
            echo ('<td align="center">' . match ($gender) {
                -1 => 'Ж',
                0 => '?',
                1 => 'М'
            }
            . '</td><td>' . getShortName($value['fullname']) . '</td><td>' . $value['job'] . '</td></tr>');
        }
        echo ('</table>');

        echo ('<br><hr>');
        echo ('<h3>Гендерный состав:</h3>');

        getGenderDescription($example_persons_array);

        echo ('<br><hr>');
        echo ('<h3>Подбор пары:</h3>');

        if ($_POST) {
            if (array_key_exists('name', $_POST)) {
                $name = htmlspecialchars($_POST["name"]);
            }
            if (array_key_exists('patronomyc', $_POST)) {
                $patronomyc = htmlspecialchars($_POST["patronomyc"]);
            }
            if (array_key_exists('surname', $_POST)) {
                $surname = htmlspecialchars($_POST["surname"]);
            }
        }

        $name = $name ?? 'Ибн';
        $patronomyc = $patronomyc ?? 'Хотабович';
        $surname = $surname ?? 'Абдурахман';
        ?>

        
        <form action="" method="post" id="partner-form">
            <label for="surname">Фамилия</label>
            <input type="text" name="surname" value="<?= $surname ?>">
            <label for="name">Имя</label>
            <input type="text" name="name" value="<?= $name ?>">
            <label for="patronomyc">Отчество</label>
            <input type="text" name="patronomyc" value="<?= $patronomyc ?>">
            <span></span>
            <input type="submit" value="Подобрать">
        </form>
        
        <div id="partner-show">
        <?php
        getPerfectPartner($surname, $name, $patronomyc, $example_persons_array);
        ?>
        </div>
    </main>
</body>

</html>