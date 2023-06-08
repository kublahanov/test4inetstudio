<?php

/**
 * Даны 2 класса. Один реализует поведение объектов, второй - сам объект.
 * Привести функцию handleObjects в соответствие с принципом открытости-закрытости (O: Open-Closed Principle) SOLID.
 * (код представлен в папке architecture, в файле solid_o.php)
 */

/**
 * SomeObject.
 */
class SomeObject
{
    /**
     * @param string $name
     */
    public function __construct(public string $name)
    {
    }

    /**
     * @return string
     */
    public function getObjectName(): string
    {
        return $this->name;
    }
}

/**
 * SomeObjectOne.
 */
class SomeObjectOne extends SomeObject
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct('One');
    }
}

/**
 * SomeObjectTwo.
 */
class SomeObjectTwo extends SomeObject
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct('Two');
    }
}

/**
 * SomeObjectsHandler.
 */
class SomeObjectsHandler
{
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param array $objects
     * @return array
     */
    public function handleObjects(array $objects): array
    {
        $handlers = [];

        foreach ($objects as $object) {
            /** @var $object SomeObject */
            $handlers[] = $object->getObjectName();
        }

        return $handlers;
    }
}

$objects = [
    new SomeObjectOne(),
    new SomeObjectTwo(),
];

$soh = new SomeObjectsHandler();
$handlers = $soh->handleObjects($objects);

print_r($handlers);
