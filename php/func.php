<?php

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