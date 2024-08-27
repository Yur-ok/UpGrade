<?php

class Factory
{

    /**
     * @param string $className Название класса для создания.
     * @return object Новый экземпляр класса.
     * @throws Exception Если класс не существует.
     */
    public static function createObjectFromClassName(string $className)
    {
        if (class_exists($className)) {
            return (new ReflectionClass($className))->newInstance();
        }

        throw new \RuntimeException("Class $className does not exist.\n");
    }
}


