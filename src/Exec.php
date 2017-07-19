<?php
namespace Process
{
    use Process\Interfaces\Get as Get;
    use Exception;

    /**
     * The base class of the process of execution.
     */
    abstract class Exec extends Base implements Get
    {
        /**
         * The body of the process.
         * @return void
         */
        abstract protected function exec();



        /**
         * Executes the body of the process, causing all event methods.
         * @return void
         */
        public function process()
        {
            if ($this->isEnded) return;

            try
            {
                $this->_start();
                $this->exec();
                $this->_end();
            }
            catch (Exception $error)
            {
                $this->_error($error);
            }
        }
    }
}