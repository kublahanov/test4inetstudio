<?php

/**
 * @param string $text
 * @return void
 */
function info(string $text = ''): void
{
    echo PHP_EOL;

    if (!$text) {
        return;
    }

    echo $text;
    echo PHP_EOL;
    echo str_repeat('-', mb_strlen($text));
    echo PHP_EOL;
}

$array = [
    ['id' => 1, 'date' => '12.01.2020', 'name' => 'test1',],
    ['id' => 2, 'date' => '02.05.2020', 'name' => 'test2',],
    ['id' => 4, 'date' => '08.03.2020', 'name' => 'test4',],
    ['id' => 1, 'date' => '22.01.2020', 'name' => 'test1',],
    ['id' => 2, 'date' => '11.11.2020', 'name' => 'test4',],
    ['id' => 3, 'date' => '06.06.2020', 'name' => 'test3',],
];

info('Исходный массив: ');

print_r($array);

/**
 * 1. Выделить уникальные записи (убрать дубли) в отдельный массив.
 * В конечном массиве не должно быть элементов с одинаковым id.
 */

info('Задание 1: Выбираем уникальные по полю id записи.');

$resultArray = array_column($array, null, 'id');

print_r($resultArray);

/**
 * 2. Отсортировать многомерный массив по ключу (любому).
 */

info('Задание 2: Сортируем массив по полю id.');

$resultArray = array_column($array, null, 'id');
ksort($resultArray);

print_r($resultArray);

/**
 * 3. Вернуть из массива только элементы, удовлетворяющие внешним условиям (например элементы с определённым id).
 */

info('Задание 3: Фильтруем массив по полю id, и условию id > 2.');

$resultArray = array_filter($array, fn($item) => $item['id'] > 2);

print_r($resultArray);

/**
 * 4. Изменить в массиве значения и ключи (использовать name => id в качестве пары ключ => значение).
 */

info('Задание 4: Создаём массив на основе ключа по полю name.');

$resultArray = array_column($array, 'id', 'name');

print_r($resultArray);
