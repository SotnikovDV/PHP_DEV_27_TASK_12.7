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
    <?php
    require 'php/persons_array.php';
    require 'php/func.php';

    print_r($example_persons_array);

    echo('<br>'); echo('<br>');

    $arr = getPartsFromFullname($example_persons_array[0]['fullname']);    
    print_r($arr);

    echo('<br>'); echo('<br>');

    $str = getFullnameFromParts($arr['surname'], $arr['name'], $arr['patronomyc']);
    print_r($str);
    ?>

</body>

</html>