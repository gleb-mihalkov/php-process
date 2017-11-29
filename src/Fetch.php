<?php
namespace Process
{
    use Exception;
    use Throwable;

    /**
     * Базовый класс процесса перечисления элементов.
     */
    abstract class Fetch extends BaseGet
    {
        /**
         * Возвращает перечисление элементов, запуская событийные методы класса.
         * @return Iterator<mixed> Перечисление элементов.
         */
        public function process()
        {
            if ($this->isEnded) return;

            try
            {
                $this->_start();

                foreach ($this->main() as $item)
                {
                    if ($this->isEnded) return;
                    yield $item;
                }

                $this->_end();
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