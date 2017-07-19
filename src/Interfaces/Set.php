<?php
namespace Process\Interfaces
{
    /**
     * Интерфейс процесса записи элемента или элементов.
     */
    interface Set
    {
        /**
         * Записывает элемент, запуская при этом событийные методы процесса.
         * @param  mixed $item Элемент или null, если следует завершить
         *                     процесс записи.
         * @return void
         */
        public function process($item);
    }
}