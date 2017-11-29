<?php
namespace Process
{
    use Exception;
    use Throwable;

    /**
     * Базовый класс процесса последовательной записи элементов.
     */
    abstract class Write extends BaseSet
    {
        /**
         * Записывает очередной элемент, запуская событийные методы класса.
         * @param  mixed $item Элемент или null, если следует завершить процесс записи.
         * @return void
         */
        public function process($item)
        {
            if ($this->isEnded) return;

            try
            {
                $this->_start();

                if ($item === null)
                {
                    $this->_end();
                    return;
                }

                $this->main($item);
            }
            catch (Throwable $error)
            {
                $this->_error($error);
            }
            catch (Exception $error)
            {
                $this->_error($error);
            }
        }
    }
}