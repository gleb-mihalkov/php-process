<?php
namespace Process
{
    use Exception;

    /**
     * Базовый класс процесса последовательного чтения элементов.
     */
    abstract class Read extends BaseGet
    {
        /**
         * Читает очередной элемент, запуская событийные методы класса.
         * @return mixed Очередной элемент или null, если элементы закончились.
         */
        public function process()
        {
            if ($this->isEnded) return null;

            try
            {
                $this->_start();

                $item = $this->main();

                if ($item === null)
                {
                    $this->_end();
                }

                return $item;
            }
            catch (Exception $error)
            {
                $this->_error($error);
            }
        }
    }
}