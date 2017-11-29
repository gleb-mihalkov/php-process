<?php
namespace Process
{
    use Exception;
    use Throwable;

    /**
     * Базовый класс процесса однократного выполнения действия.
     */
    abstract class Exec extends BaseGet
    {
        /**
         * Выполняет действие, запуская событийные методы класса.
         * @return void
         */
        public function process()
        {
            if ($this->isEnded) return;

            try
            {
                $this->_start();
                $this->main();
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