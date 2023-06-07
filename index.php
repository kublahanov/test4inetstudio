<?php

/**
 * Форматированный вывод.
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

/**
 * Начало.
 */

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

/**
 * 5. В базе данных имеется:
 * - таблица с товарами goods (id INTEGER, name TEXT),
 * - таблица с тегами tags (id INTEGER, name TEXT)
 * - и таблица связи товаров и тегов goods_tags (tag_id INTEGER, goods_id INTEGER, UNIQUE(tag_id, goods_id)).
 * Выведите id и названия всех товаров, которые имеют все возможные теги в этой базе.
 * На выходе: SQL-запрос.
 */

info('Задание 5: SQL-запрос.');

$query = "
    SELECT
        g.id, g.name
    FROM
        tags t
    INNER JOIN
        goods_tags gt
        ON gt.tag_id = t.id
    INNER JOIN
        goods g
        ON g.id = gt.goods_id
    GROUP BY
        g.id, g.name
    HAVING
        COUNT(t.id) = (SELECT COUNT(*) FROM tags)
";

print_r($query);

/**
 * 6. Выбрать без join-ов и подзапросов все департаменты, в которых есть мужчины,
 * и все они (каждый) поставили высокую оценку (строго выше 5).
 * create table evaluations
 * (
 *     respondent_id uuid primary key, -- ID респондента
 *     department_id uuid,             -- ID департамента
 *     gender        boolean,          -- true — мужчина, false — женщина (сексизм?)
 *     value         integer           -- Оценка
 * );
 * На выходе: SQL-запрос.
 */

info('Задание 6: SQL-запрос.');

$query = "
";

print_r($query);

/**
 * Окончание.
 */

info();
