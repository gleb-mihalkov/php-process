<?php
namespace Process\Interfaces
{
    /**
     * Интерфейс процесса получения элементов или элемента.
     */
    interface Get
    {
        /**
         * Получает элемент или элементы, запуская при этом событийные методы процесса.
         * @return mixed Элемент или элементы.
         */
        public function process();
    }
}