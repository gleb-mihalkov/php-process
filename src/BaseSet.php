<?php
namespace Process
{
    use Process\Interfaces\Set as SetInterface;

    /**
     * Базовый класс процесса записи элемента или элементов.
     */
    abstract class BaseSet extends Base implements SetInterface
    {
        /**
         * Записывает элемент.
         * @param  mixed $item Элемент или null, если процесс записи следует завершить.
         * @return void
         */
        abstract protected function main($item);
    }
}