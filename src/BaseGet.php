<?php
namespace Process
{
    use Process\Interfaces\Get as GetInterface;

    /**
     * Базовый класс процесса получения элементов или элемента.
     */
    abstract class BaseGet extends Base implements GetInterface
    {
        /**
         * Метод, получающий элемент или элементы.
         * @return mixed Элемент или null, если элементы кончились.
         */
        abstract protected function main();
    }
}