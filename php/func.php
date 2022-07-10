<?php

// выводит отладочные сообщения в js console
function console_log($str) {
    echo ('<script> console.log("'.$str.'"); </script> ');
}

// принимает как аргумент одну строку — склеенное ФИО. Возвращает как результат массив из трёх элементов с ключами ‘name’, ‘surname’ и ‘patronomyc’
function getPartsFromFullname ( $fullname ){
    $arrayKeys = [ 'surname', 'name', 'patronomyc'];
    $arrayValues = explode(' ', $fullname);
    
    return array_combine( $arrayKeys, $arrayValues );
}

// принимает как аргумент три строки — фамилию, имя и отчество. Возвращает как результат их же, но склеенные через пробел
function getFullnameFromParts ( $surname, $name, $patronomyc ){
    
    return  "$surname $name $patronomyc";
    
}

// принимает как аргумент строку, содержащую ФИО вида «Иванов Иван Иванович» 
// и возвращает строку вида «Иван И.», где сокращается фамилия и отбрасывается отчество
function getShortName( $fullname ) {
   $pers = getPartsFromFullname( $fullname );
   return $pers['name'].' '.mb_substr($pers['surname'],0,1).'.';
}

// принимает как аргумент строку, содержащую ФИО (вида «Иванов Иван Иванович»)
// пытается определить пол по окончаниям имени, фамилии, отчества
// возвращает: 1 - мужской пол, -1 (женский пол), 0 (неопределенный пол)
function getGenderFromName( $fullname ) {
   $gender = 0;
   $pers = getPartsFromFullname ( $fullname );
   
   console_log($fullname);

   // проверяем признаки женского пола
   if (mb_substr($pers['patronomyc'],-3,3) == 'вна') {
    $gender--;
    console_log('-отчество заканчивается на вна');
   }
   if (mb_substr($pers['name'],-1,1) == 'а') {
    $gender--;
    console_log('-имя заканчивается на а');
   }
   if (mb_substr($pers['surname'],-2,2) == 'ва') {
    $gender--;
    console_log('-фамилия заканчивается на ва');
   }

   // проверяем признаки мужского пола
   if (mb_substr($pers['patronomyc'],-2,2) == 'ич') {
    $gender++;
    console_log('+отчество заканчивается на ич');
   }
   if (in_array(mb_substr($pers['name'],-1,1), ['а', 'н'])) {
    $gender++;
    console_log('+имя заканчивается на й или н');
   }
   if (mb_substr($pers['surname'],-1,1) == 'в') {
    $gender++;
    console_log('+фамилия заканчивается на в');
   }

   // возвращаем результат
   if ($gender == 0) {
    return 0;
   } else {
    return ($gender > 0) ? 1 : -1;
   }
}

// функция для определения полового состава аудитории. Как аргумент в функцию передается массив
// результат работы - вывод на страницу статистики по гендерному составу
function getGenderDescription($arr) {
    echo ('Гендерный состав аудитории: <br>');
    echo('--------------------------------<br>');
    
    $gend_agr = [-1 => 0, 0 => 0, 1 => 0];
    
    foreach ($arr as $key => $value) {
        $gender = getGenderFromName($value['fullname']);
        $gend_agr[$gender]++;
    }

    foreach ($gend_agr as $key => $value) {
        echo ( match($key) {-1 => 'Женщины', 0 => 'Не удалось определить', 1 => 'Мужчины'} . ' - ' . round( $value / count($arr) * 100, 1) . '%<br>' );
    }
}

//  функции для подбора пары
// первые три аргумента: фамилия, имя и отчество
// 4-й аргумент - массив типа $example_persons_array
// выводит на страницу рекламный бред про идеально подобранную пару из массива
function getPerfectPartner( $surname, $name, $patronomyc, $arr ) {

    // получем полное ФИО
    $fullname = getFullnameFromParts( mb_convert_case($surname, MB_CASE_TITLE_SIMPLE),
                    mb_convert_case($name, MB_CASE_TITLE_SIMPLE), 
                    mb_convert_case($patronomyc, MB_CASE_TITLE_SIMPLE) );

    // определяем пол
    $gender = getGenderFromName($fullname);

    // бесполых игнорируем
    if ($gender == 0) {
        echo( getShortName($fullname) . ' находится в процессе гендерного определения<br>' );
        echo( 'К сожалению, мы не можем подобрать ему пару прямо сейчас.<br>' );
        echo( 'Приходите, когда определитесь...' );
        return;
    // для дам    
    } elseif ($gender == -1) {
        // сформируем подмассив мужиков
        $anti_gender_pers = array_filter($arr, function ($pers){
            return getGenderFromName($pers['fullname']) == 1;
        });
        // для мужиков
    } elseif ($gender == 1) {
        // сформируем подмассив девушек
        $anti_gender_pers = array_filter($arr, function ($pers){
            return getGenderFromName($pers['fullname']) == -1;
        });
    }
    
    // переиндексируем подмассив
    $anti_gender_pers = array_values($anti_gender_pers);

    // возмем случайный антипод
    $rand_pers = mt_rand(0, count($anti_gender_pers)-1);
    $anti_gender_fullname = $anti_gender_pers[$rand_pers]['fullname'];

    // вывод на страницу
    echo ( '<b>'.getShortName($fullname) . ' + ' . getShortName($anti_gender_fullname) . ' =<br>');
    echo ( '♡ Идеально на ' . mt_rand(5000, 10000) / 100 . '% ♡</b>');

}   